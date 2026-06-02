<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = Banner::active()->visibility()->isSingle(false)->with('media')->paginate($request->query('per_page', 20));

        return Response::ok(message: __('lang.banners'), data: BannerResource::collection($banners), paginate: true);
    }

    public function singleBanners()
    {
        $banner = Banner::active()->visibility()->isSingle()->with('media')->first();

        return Response::ok(message: __('lang.banners'), data: $banner ? new BannerResource($banner) : null);
    }
}
