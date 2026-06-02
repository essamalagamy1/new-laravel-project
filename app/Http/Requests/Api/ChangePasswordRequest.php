<?php

namespace App\Http\Requests\Api;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class ChangePasswordRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'old_password' => 'bail|required|string',
            'new_password' => 'bail|required|string|min:6',
            'password_confirmation' => 'bail|required|string|same:new_password',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (! Hash::check($this->old_password, auth()->user()->password)) {
                    $validator->errors()->add('old_password', __('lang.old_password_not_correct'));
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
