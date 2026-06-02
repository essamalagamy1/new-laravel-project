<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollegeResource;
use App\Models\College;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CollegeController extends Controller
{
    public function index(Request $request)
    {
        $courses = College::when($request->universitie_id, function ($q) use ($request) {
            $q->whereHas('universities', function ($q) use ($request) {
                $q->where('universities.id', $request->universitie_id);
            });
        })->when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%");
        })->latest()->with('universities')->withCount('courses')->paginate($request->query('per_page', 20));

        return Response::ok(message: __('lang.colleges'), data: CollegeResource::collection($courses), paginate: true);
    }

    public function educationStage(College $college)
    {
        $data = $college->courses->map(function (Course $course) {
            return (int) $course->pivot?->education_stage;
        });

        return Response::ok(message: __('lang.education_stage'), data: $data);
    }
}
