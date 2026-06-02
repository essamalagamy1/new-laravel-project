<?php

namespace App\Http\Resources;

use App\Support\DateTime\TimezoneService;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Format the date for the API consumer based on their timezone.
     */
    protected function formatTzDate($date): ?string
    {
        if (! $date) {
            return null;
        }

        return app(TimezoneService::class)
            ->toUserTime($date, auth('sanctum')->user())
            ?->toIso8601String();
    }
}
