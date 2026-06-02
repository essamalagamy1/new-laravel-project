<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PaymentMethodRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_slug' => [
                'required',
                'string',
                Rule::exists('payment_gateways', 'slug')->where('is_active', true),
            ],
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
