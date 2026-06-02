<?php

namespace App\Http\Controllers;

use App\Actions\Enrollment\ConfirmEnrollmentAction;
use App\Enums\PaymentStatus;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Requests\Api\PaymentMethodRequest;
use App\Models\Enrollment;
use App\Services\Payment\PaymentGatewayFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Throwable;

class PaymentController extends Controller
{
    public function __construct(private readonly PaymentGatewayFactory $factory) {}

    public function paymentMethods(PaymentMethodRequest $request): JsonResponse
    {
        try {
            $gateway = app(PaymentGatewayFactory::class)->make($request->payment_slug);

            return Response::ok(__('lang.success'), [
                'gateway' => config('payment.default_gateway'),
                'methods' => $gateway->getPaymentMethods(),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return Response::error(__('lang.server_error'), status: 500);
        }
    }

    public function checkout(CheckoutRequest $request)
    {
        try {
            $gateway = $this->factory->make($request->payment_slug);
            $result = $gateway->charge($request);

            return Response::ok($result['message'] ?? '', $result);
        } catch (Throwable $exception) {
            report($exception);
            $message = app()->isLocal() ? $exception->getMessage() : __('lang.server_error');

            return Response::error($message, status: 422);
        }
    }

    public function success(Request $request)
    {
        $enrollment = Enrollment::where('transaction_id', $request->invoice_id)->firstOrFail();
        $payment_slug = $enrollment->payment_method;
        $gateway = $this->factory->make($payment_slug);
        $verification_result = $gateway->verify($request->invoice_id);
        if ($verification_result['status'] === 'success') {
            $data['sync_wallet'] = true;
            (new ConfirmEnrollmentAction)->execute($enrollment, $data);
        }

        return Response::ok(__('lang.payment_successful'));
    }

    public function failure(Request $request)
    {
        $enrollment = Enrollment::where('transaction_id', $request->invoice_id)->firstOrFail();
        $payment_slug = $enrollment->payment_method;
        $gateway = $this->factory->make($payment_slug);
        $verification_result = $gateway->verify($request->invoice_id);
        if ($verification_result['status'] !== 'success') {
            $enrollment->update([
                'payment_status' => PaymentStatus::Failed,
            ]);
        }

        // Handle failed payment callback (if needed).
        return Response::ok(__('lang.payment_failed'));
    }

    public function pending(Request $request)
    {
        Log::info('Payment pending callback received', [
            'request' => $request->all(),
        ]);

        // Handle pending payment callback (if needed).
        return Response::ok(__('lang.payment_pending'));
    }

    public function webhook(Request $request)
    {
        $enrollment = Enrollment::where('transaction_id', $request->invoice_id)->firstOrFail();
        $payment_slug = $enrollment->payment_method;
        $gateway = $this->factory->make($payment_slug);
        $verification_result = $gateway->verify($request->invoice_id);
        if ($verification_result['status'] === 'success') {
            $data['sync_wallet'] = true;
            (new ConfirmEnrollmentAction)->execute($enrollment, $data);
        } else {
            $enrollment->update([
                'payment_status' => PaymentStatus::Failed,
            ]);
        }

        return Response::ok(__('lang.webhook_received'));
    }
}
