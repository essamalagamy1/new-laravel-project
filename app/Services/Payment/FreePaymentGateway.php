<?php

namespace App\Services\Payment;

use App\Actions\Enrollment\ConfirmEnrollmentAction;
use App\Actions\Enrollment\CreateEnrollmentAction;
use App\Enums\EnrollmentStatus;
use App\Enums\PaymentStatus;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use RuntimeException;

class FreePaymentGateway implements PaymentGatewayInterface
{
    public function __construct(
        private readonly CreateEnrollmentAction $createEnrollmentAction,
        private readonly ConfirmEnrollmentAction $confirmEnrollmentAction
    ) {}

    public function getPaymentMethods(): array
    {
        // Free gateway has no external payment methods.
        return [];
    }

    public function charge(Request $request): array
    {
        $course = Course::query()->where('slug', $request->course_slug)->firstOrFail();
        $user = $request->user();
        $payment_gateway = PaymentGateway::query()->active()->where('slug', $request->payment_slug)->firstOrFail();

        try {
            DB::beginTransaction();

            $enrollment = $this->createEnrollmentAction->execute([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'coupon_id' => $request->coupon ? Coupon::where('code', $request->coupon)->first()?->id : null,
                'payment_gateway_id' => $payment_gateway->id,
                'payment_method' => $payment_gateway->slug,
                'status' => EnrollmentStatus::Confirmed,
                'payment_status' => PaymentStatus::Paid,
                'transaction_id' => uniqid(),
                'paid_at' => now(),
            ]);

            if (round((float) $enrollment->final_price, 2) > 0) {
                DB::rollBack();

                return [
                    'message' => __('lang.this_gateway_only_for_free_courses'),
                    'status' => 'failed',
                    'payment_url' => null,
                    'data' => null,
                ];
            }

            $enrollment->refresh();

            $this->confirmEnrollmentAction->execute($enrollment, [
                'mark_as_paid' => true,
                'sync_wallet' => true,
            ]);

            DB::commit();

            return [
                'message' => __('lang.payment_successful'),
                'status' => 'success',
                'payment_url' => null,
                'data' => [
                    'enrollment_id' => $enrollment->id,
                    'enrollment_code' => $enrollment->enrollment_code,
                ],
            ];
        } catch (\Throwable $exception) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            report($exception);

            return Response::error(__('lang.server_error'), status: 500);
        }
    }

    public function refund(string $transactionId, float $amount): array
    {
        throw new RuntimeException('Free payment refund is not supported.');
    }

    public function verify(string $transactionId): array
    {
        throw new RuntimeException('Free payment verify is not supported.');
    }
}
