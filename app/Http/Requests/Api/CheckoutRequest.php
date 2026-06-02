<?php

namespace App\Http\Requests\Api;

use App\Enums\EnrollmentStatus;
use App\Enums\PaymentStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Rules\CouponValidityCheckRule;
use App\Services\Payment\PaymentGatewayFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class CheckoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'course_slug' => ['bail', 'required', 'string', 'exists:courses,slug'],
            'payment_slug' => [
                'required',
                'string',
                Rule::exists('payment_gateways', 'slug')->where('is_active', true),
            ],
            'payment_method_id' => ['nullable', 'integer', 'min:1'],
            'coupon' => ['bail', 'nullable', 'string', 'exists:coupons,code', new CouponValidityCheckRule($this->course_slug)],
            'mobile_wallet_number' => ['bail', 'nullable', 'required_if:payment_method_id,4', 'string', 'max:255'],
            'receipt' => ['bail', 'required_if:payment_slug,manual_transfer', 'nullable', 'image', 'max:4096'],
        ];
    }

    // if user is enrolled in this course before
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $course = Course::active()->approval()->where('slug', $this->course_slug)->firstOrFail();

            $is_already_enrolled = Enrollment::query()
                ->where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->where('status', EnrollmentStatus::Confirmed)
                ->where('payment_status', PaymentStatus::Paid)
                ->exists();

            if ($is_already_enrolled) {
                $validator->errors()->add('course_slug', __('lang.user_already_enrolled'));
            }

            if ($this->payment_method_id) {
                $gateway = app(PaymentGatewayFactory::class)->make($this->payment_slug);
                $methodIds = collect($gateway->getPaymentMethods())->pluck('payment_method_id')->toArray();
                if (! in_array($this->payment_method_id, $methodIds)) {
                    $validator->errors()->add('payment_method_id', __('lang.invalid_payment_method'));
                }
            }
        });
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        throw new ValidationException($validator, Response::validationError($validator));
    }

    public function authorize(): bool
    {
        return true;
    }
}
