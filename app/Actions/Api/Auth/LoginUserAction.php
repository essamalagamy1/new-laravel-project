<?php

namespace App\Actions\Api\Auth;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Str;

class LoginUserAction
{
    public function execute(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        abort_unless($user, 404, __('lang.user_not_found'));

        if (empty($user->device_id)) {
            $user->update(['device_id' => $data['device_id']]);
        }
        // Single-device login: revoke all previous tokens
        $user->tokens()->delete();

        if (isset($data['fcm_token'])) {
            $user->update(['fcm_token' => $data['fcm_token']]);
        }
        $user->update(['student_instructor_code' => $data['instructor_code'] ?? null]);

        return [
            'token' => $user->createToken(Str::random(50))->plainTextToken,
            'user' => new UserResource($user),
        ];
    }
}
