<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'phone_key' => $this->phone_key,
            'phone' => $this->phone,
            'full_phone' => $this->full_phone,
            'image' => $this->getFirstMediaUrl('image'),
        ];
    }
}
