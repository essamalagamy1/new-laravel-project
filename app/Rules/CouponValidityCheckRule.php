<?php

namespace App\Rules;

use App\Models\Coupon;
use App\Models\Course;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CouponValidityCheckRule implements ValidationRule
{
    public function __construct(private readonly ?string $course_slug) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $coupon = Coupon::query()->where('code', $value)->first();
        $course = Course::active()->approval()->where('slug', $this->course_slug)->first();

        if (! $coupon) {
            $fail(__('lang.invalid_coupon_code'));
        }

        if ($coupon->isExpired()) {
            $fail(__('lang.coupon_expired'));
        }

        if ($coupon->hasReachedLimit()) {
            $fail(__('lang.coupon_usage_limit_reached'));
        }

        if (! $coupon->isActive()) {
            $fail(__('lang.coupon_inactive'));
        }

        if ($course && $coupon->course_id && $coupon->course_id !== $course->id) {
            $fail(__('lang.coupon_not_applicable_for_course'));
        }

        if ($course && $course->price < $coupon->min_order_value) {
            $fail(__('lang.minimum_order_value_required', [
                'value' => $coupon->min_order_value,
            ]));
        }

        if (auth()->check()) {
            $used = \DB::table('enrollments')
                ->where('user_id', auth()->id())
                ->where('coupon_id', $coupon->id)
                ->exists();

            if ($used) {
                $fail(__('lang.coupon_already_used'));
            }
        }
    }
}
