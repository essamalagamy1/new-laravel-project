<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->data['title'][app()->getLocale()],
            'body' => $this->data['body'][app()->getLocale()],
            'is_read' => $this->read_at ? true : false,
            'data' => $this->data['data'] ?? null,
            'created_at' => $this->created_at,
            'created_at_human' => Carbon::parse($this->created_at)->diffForHumans(),
        ];
    }
}
