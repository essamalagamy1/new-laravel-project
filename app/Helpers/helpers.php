<?php

use App\Support\DateTime\TimezoneService;
use Illuminate\Support\Facades\Http;

if (! function_exists('getTimezoneByIP')) {
    function getTimezoneByIP($ip): ?string
    {
        if (app()->isProduction()) {
            $request = Http::get('https://freeipapi.com/api/json/'.$ip);
            if ($request->json() && array_key_exists('timeZones', $request->json())) {
                return $request['timeZones'][0];
            }
        }

        return config('app.timezone');
    }
}

if (! function_exists('formatDate')) {
    function formatDate($date = null, $with_time = false): ?string
    {
        if (! $date) {
            return null;
        }

        return app(TimezoneService::class)->format($date, $with_time, auth()->user());
    }
}

if (! function_exists('randomOtpCode')) {
    function randomOtpCode(): string
    {
        return 1234;
    }
}

if (! function_exists('formatDuration')) {
    function formatDuration($totalSeconds): string
    {
        $h = app()->getLocale() === 'ar' ? 'س' : 'h';
        $m = app()->getLocale() === 'ar' ? 'د' : 'm';
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        if ($hours > 0) {
            return "{$hours}{$h} {$minutes}{$m}";
        }

        return "{$minutes}{$m}";
    }
}

if (! function_exists('priceWithTax')) {
    function priceWithTax($price): float
    {
        $taxPercentage = siteSetting()->tax_percentage;

        return round($price + ($price * $taxPercentage / 100), 2);
    }
}
