<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class BannerResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        $url = null;
        if ($this->url) {
            $url = $this->url;
        } elseif ($this->course?->slug) {
            $url = config('app.url').'/course?slug='.$this->course->slug;
        }

        return [
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->getFirstMediaUrl('image'),
            'course_slug' => $this->course?->slug ?? null,
            'url' => $url,
        ];
    }
}
