<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class NotificationRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'notification_id' => 'required|exists:notifications,id',
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
