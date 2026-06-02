<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SiteSettingResource;
use Illuminate\Support\Facades\Response;

class SiteSettingController extends Controller
{
    public function __invoke()
    {
        return Response::ok(__('lang.data'), data: new SiteSettingResource(siteSetting()));
    }
}
