<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class LoginRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email' => ['bail', 'required', 'email'],
            'password' => ['bail', 'required', 'min:8'],
            'fcm_token' => ['nullable', 'string', 'max:255'],
            'device_id' => ['required', 'string', 'max:255'],
            'instructor_code' => ['nullable', 'string', 'max:255', 'exists:users,instructor_code'],
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (! auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
                    $validator->errors()->add('password', __('auth.failed'));
                }
                if (User::where('email', $this->email)->exists() && ! User::where('email', $this->email)->first()->hasVerifiedEmail()) {
                    $validator->errors()->add('email', __('lang.email_not_verified'));
                }
                $user = User::where('email', $this->email)->first();
                if ($user->device_id && $user->device_id !== $this->device_id) {
                    $validator->errors()->add('device_id', __('lang.device_not_allowed'));
                }
            },
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        throw new ValidationException($validator, Response::validationError($validator));
    }

    public function authorize(): bool
    {
        return true;
    }
}
