<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class ResetPasswordRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'email' => ['bail', 'required', 'email:dns', 'exists:users,email'],
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ];
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
