<?php

namespace App\Services\Payment;

use App\Actions\Enrollment\CreateEnrollmentAction;
use App\Enums\PaymentStatus;
use App\Http\Resources\EnrollmentResource;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\PaymentGateway;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class FawaterakGateway implements PaymentGatewayInterface
{
    private string $apiKey;

    private string $baseUrl;

    private array $paymentIds;

    public function __construct(string $apiKey, private readonly array $redirectionUrls, bool $sandbox, private readonly CreateEnrollmentAction $createEnrollmentAction)
    {
        $this->apiKey = trim(str_ireplace('Bearer ', '', $apiKey));

        $this->baseUrl = $sandbox
            ? 'https://staging.fawaterk.com/api/v2'
            : 'https://app.fawaterk.com/api/v2';
        $this->paymentIds = $sandbox
            ? [3, 4, 2, 11] // Fawry,Wallet, Visa, Value
            : [3, 4, 9]; // Fawry,Wallet, Visa
    }

    public function getPaymentMethods(): array
    {
        $response = $this->request()->get("{$this->baseUrl}/getPaymentmethods");

        if ($response->failed()) {
            throw new RuntimeException('Fawaterak methods request failed: '.$response->body());
        }

        $body = $response->json();

        if (($body['status'] ?? '') !== 'success') {
            throw new RuntimeException('Fawaterak methods error: '.($body['message'] ?? 'Unknown error'));
        }

        return collect($body['data'] ?? [])
            ->filter(fn ($method) => in_array((int) ($method['paymentId'] ?? 0), $this->paymentIds))
            ->map(function (array $method): array {
                return [
                    'payment_method_id' => (int) ($method['paymentId'] ?? 0),
                    'name_en' => $method['name_en'] ?? null,
                    'name_ar' => $method['name_ar'] ?? null,
                    'redirect' => filter_var($method['redirect'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'logo' => $method['logo'] ?? null,
                ];
            })->values()->toArray();
    }

    // ─── charge ────────────────────────────────────────────────────────────────

    public function charge(Request $request): array
    {
        $course = Course::query()->where('slug', $request->course_slug)->firstOrFail();
        $user = $request->user();
        $payment_gateway = PaymentGateway::query()->active()->where('slug', $request->payment_slug)->firstOrFail();
        $enrollment = null;

        try {
            DB::beginTransaction();
            $enrollment = $this->createEnrollmentAction->execute([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'coupon_id' => $request->coupon ? Coupon::where('code', $request->coupon)->first()?->id : null,
                'payment_gateway_id' => $payment_gateway->id,
                'payment_method' => $request->payment_slug,
                'payment_status' => PaymentStatus::Pending,
            ]);

            $data = [
                'payment_method_id' => $request->payment_method_id ?? 2, // Visa-Mastercard
                'amount' => (float) $enrollment->final_price,
                'currency' => 'EGP',
                'invoice_number' => $enrollment->enrollment_code,
                'customer' => [
                    'first_name' => $user->first_name ?? $user->name,
                    'last_name' => $user->last_name ?? '',
                    'email' => $user->email,
                    'phone' => $user->full_phone,
                    'id' => $user->id,
                ],
                'mobile_wallet_number' => $request->mobile_wallet_number,
                'items' => [[
                    'name' => (string) $course->name,
                    'price' => (float) $enrollment->final_price,
                    'quantity' => 1,
                ]],
            ];

            $payload = $this->buildPayload($data);
            $response = $this->request()->post("{$this->baseUrl}/invoiceInitPay", $payload);

            if ($response->failed()) {
                throw new RuntimeException(
                    'Fawaterak request failed: '.$response->body()
                );
            }

            $body = $response->json();

            if (($body['status'] ?? '') !== 'success') {
                throw new RuntimeException(
                    'Fawaterak error: '.($body['message'] ?? 'Unknown error')
                );
            }

            $invoiceData = $body['data'] ?? [];
            $payment_url = data_get($invoiceData, 'payment_data.redirectTo');
            $transaction_id = isset($invoiceData['invoice_id']) ? (string) $invoiceData['invoice_id'] : null;

            $enrollment->update([
                'transaction_id' => $transaction_id,
            ]);

            DB::commit();

            return [
                'message' => __('lang.url_redirected'),
                'status' => 'success',
                'payment_url' => $payment_url,
                'wallet' => $request->payment_method_id == 4 ? $invoiceData['payment_data'] : null,
                'fawry' => $request->payment_method_id == 3 ? $invoiceData['payment_data'] : null,
                'value' => $request->payment_method_id == 11 ? $invoiceData['payment_data'] : null,
                'data' => $invoiceData,
                //                'enrollment' => new EnrollmentResource($enrollment),
            ];
        } catch (\Throwable $exception) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            report($exception);
            throw $exception;
        }

    }

    // ─── verify ────────────────────────────────────────────────────────────────

    public function verify(string $transactionId): array
    {
        $response = $this->request()->get("{$this->baseUrl}/getInvoiceData/{$transactionId}");

        if ($response->failed()) {
            throw new RuntimeException('Fawaterak verify failed: '.$response->body());
        }

        $body = $response->json();

        // $body['data']['status_text'] ?? 'unknown',
        return [
            'status' => array_key_exists('data', $body) && ($body['data']['status_text'] ?? '') === 'paid' ? 'success' : $body['data']['status_text'],
            'transaction_id' => $transactionId,
            'raw' => $body['data'] ?? [],
        ];
    }

    // ─── refund ────────────────────────────────────────────────────────────────

    public function refund(string $transactionId, float $amount): array
    {
        // Fawaterak refund endpoint — راجع الـ docs لو اتغير
        $response = $this->request()->post("{$this->baseUrl}/refund", [
            'invoice_id' => $transactionId,
            'amount' => $amount,
        ]);

        if ($response->failed()) {
            throw new RuntimeException('Fawaterak refund failed: '.$response->body());
        }

        return [
            'status' => 'refunded',
            'transaction_id' => $transactionId,
            'raw' => $response->json(),
        ];
    }

    // ─── helpers ───────────────────────────────────────────────────────────────

    private function request(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer '.$this->apiKey,
            'Accept' => 'application/json',
            // Fawaterak validates this header even for GET requests.
            'Content-Type' => 'application/json',
        ]);
    }

    private function buildPayload(array $data): array
    {
        return [
            'payment_method_id' => $data['payment_method_id'],
            'cartTotal' => $data['amount'],
            'currency' => $data['currency'] ?? 'EGP',
            'invoice_number' => $data['invoice_number'] ?? null,
            'invoice_id' => $data['invoice_id'] ?? null,

            'customer' => [
                'first_name' => $data['customer']['first_name'],
                'last_name' => $data['customer']['last_name'],
                'email' => $data['customer']['email'] ?? null,
                'phone' => $data['customer']['phone'] ?? null,
                'address' => $data['customer']['address'] ?? null,
                'customer_unique_id' => $data['customer']['id'] ?? null,
            ],

            'cartItems' => $data['items'] ?? [[
                'name' => $data['description'] ?? 'Order',
                'price' => $data['amount'],
                'quantity' => 1,
            ]],

            'redirectionUrls' => array_merge(
                $this->redirectionUrls,
                $data['redirectionUrls'] ?? []   // تقدر تـ override لكل request
            ),

            // حقول اختيارية
            'sendEmail' => $data['sendEmail'] ?? false,
            'sendSMS' => $data['sendSMS'] ?? false,
            'due_date' => $data['due_date'] ?? null,
            'payLoad' => $data['payload'] ?? null,
            'discountData' => $data['discountData'] ?? null,
            'taxData' => $data['taxData'] ?? null,
            'frequency' => $data['frequency'] ?? 'once',
            'mobileWalletNumber' => $data['mobile_wallet_number'] ?? null,
            'redirectOption' => $data['redirect_option'] ?? false,
            'lang' => $data['lang'] ?? app()->getLocale(),
        ];
    }
}
