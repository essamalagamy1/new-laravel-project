<?php

use App\Enums\Status;
use App\Models\Banner;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

if (! function_exists('siteSetting')) {
    function siteSetting()
    {
        return Cache::remember('site_setting', 3600, function () {
            return SiteSetting::with('media')->first();
        });
    }
}

if (! function_exists('categories')) {
    function categories()
    {
        return Cache::remember('categories', 3600, function () {
            return Category::where('status', Status::Active)
                ->whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->where('status', Status::Active);
                }])->get();
        });
    }
}

if (! function_exists('banners')) {
    function banners()
    {
        return Cache::remember('banners', 3600, function () {
            return Banner::where('status', Status::Active)
                ->with('product')
                ->orderByRaw('COALESCE(sort, 999999) ASC')
                ->get();
        });
    }
}

if (! function_exists('roles')) {
    function roles()
    {
        return Cache::remember('roles_list', 3600, function () {
            return Role::where('is_main', false)->get(['id', 'name'])->toArray();
        });
    }
}

if (! function_exists('clearRolesCache')) {
    function clearRolesCache(): void
    {
        Cache::forget('roles_list');
    }
}

if (! function_exists('loadTimezones')) {
    function loadTimezones(): array
    {
        return Cache::rememberForever('timezones_list', function () {
            $json = file_get_contents(public_path('timezones.json'));

            return collect(json_decode($json, true))
                ->map(function ($timezone) {
                    return [
                        'id' => $timezone['utc'][0] ?? null,
                        'name' => $timezone['text'],
                    ];
                })
                ->filter(fn ($timezone) => $timezone['id'] !== null)
                ->values()
                ->toArray();
        });
    }
}
