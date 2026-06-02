<?php

namespace App\Http\Controllers\Api;

use App\Actions\Enrollment\ApplyCouponAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CourseGetPriceRequest;
use App\Http\Resources\CourseResource;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Support\Facades\Response;

class CouponController extends Controller
{
    public function __invoke(CourseGetPriceRequest $request)
    {
        $course = Course::where('slug', $request->course_slug)->active()->approval()->visibility()
            ->with(['instructor' => fn ($q) => $q->withCount(['instructorCourses', 'instructorCourseEnrollments'])->withAvg('instructorCourses', 'rating'),
            ])->firstOrFail();
        $coupon = Coupon::where('code', $request->coupon)->firstOrFail();
        $apply_coupon = (new ApplyCouponAction)->execute($course, $coupon);

        return Response::ok(message: __('lang.course'), data: new CourseResource($course));
    }
}
