<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class VerifyCodeRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email' => ['bail', 'required', 'email:dns', 'exists:users,email'],
            'verification_code' => 'bail|required|numeric|exists:users,verification_code',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $user = User::where('email', $this->email)->first();
            if ($user && $user->verification_code != $this->verification_code) {
                $validator->errors()->add('otp', __('lang.invalid_code'));
            }
        });
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator, Response::validationError($validator));
    }

    public function authorize(): bool
    {
        return true;
    }
}
