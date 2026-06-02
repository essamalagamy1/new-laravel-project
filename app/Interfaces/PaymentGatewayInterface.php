<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    public function getPaymentMethods(): array;

    public function charge(Request $request): array;

    public function refund(string $transactionId, float $amount): array;

    public function verify(string $transactionId): array;
}
