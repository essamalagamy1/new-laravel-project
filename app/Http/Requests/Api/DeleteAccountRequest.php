<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class DeleteAccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => 'required|string',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (! Hash::check($this->password, auth()->user()->password)) {
                    $validator->errors()->add('password', __('lang.invalid_password'));
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
