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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use RuntimeException;

class ManualTransferGateway implements PaymentGatewayInterface
{
    public function __construct(private readonly CreateEnrollmentAction $createEnrollmentAction) {}

    public function getPaymentMethods(): array
    {
        // Manual transfer has no external provider methods.
        return [];
    }

    public function charge(Request $request): array
    {
        $course = Course::query()->where('slug', $request->course_slug)->firstOrFail();
        $user = $request->user();
        $payment_gateway = PaymentGateway::query()->active()->where('slug', $request->payment_slug)->firstOrFail();
        try {
            DB::beginTransaction();
            $this->createEnrollmentAction->execute([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'coupon_id' => $request->coupon ? Coupon::where('code', $request->coupon)->first()?->id : null,
                'payment_gateway_id' => $payment_gateway->id,
                'payment_method' => $payment_gateway->slug,
                'receipt' => $request->file('receipt'),
                'transaction_id' => uniqid(),
                'paid_at' => now(),
                'payment_status' => PaymentStatus::Paid,
            ]);
            DB::commit();

            return [
                'message' => __('lang.payment_under_review'),
                'status' => 'success',
                'payment_url' => null,
                'data' => null,
                //                'enrollment' => new EnrollmentResource($enrollment),
            ];

        } catch (\Throwable $exception) {
            DB::rollBack();
            report($exception);

            return Response::error(__('lang.server_error'), status: 500);
        }
    }

    public function refund(string $transactionId, float $amount): array
    {
        throw new RuntimeException('Manual transfer refund is not supported.');
    }

    public function verify(string $transactionId): array
    {
        throw new RuntimeException('Manual transfer verify is not supported.');
    }
}
