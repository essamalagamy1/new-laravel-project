<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class ProfileUpdateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4048',
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
