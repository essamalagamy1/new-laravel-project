<?php

namespace App\Services\Payment;

use App\Actions\Enrollment\ConfirmEnrollmentAction;
use App\Actions\Enrollment\CreateEnrollmentAction;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\PaymentGateway;
use InvalidArgumentException;

class PaymentGatewayFactory
{
    public function make(?string $gateway = null): PaymentGatewayInterface
    {
        $gatewayRecord = $gateway
            ? PaymentGateway::query()->active()->where('slug', $gateway)->first()
            : PaymentGateway::getDefaultGateway();

        $gatewaySlug = $gatewayRecord?->slug ?? $gateway ?? config('payment.default_gateway');

        return match ($gatewaySlug) {
            'fawaterak', 'fawaterk' => $this->makeFawaterakGateway($gatewayRecord),
            'manual_transfer' => $this->makeManualTransferGateway(),
            'free_payment' => $this->makeFreePaymentGateway(),
            default => throw new InvalidArgumentException("Gateway [{$gatewaySlug}] not found."),
        };
    }

    private function makeManualTransferGateway(): PaymentGatewayInterface
    {
        return new ManualTransferGateway(createEnrollmentAction: app(CreateEnrollmentAction::class));
    }

    private function makeFreePaymentGateway(): PaymentGatewayInterface
    {
        return new FreePaymentGateway(
            createEnrollmentAction: app(CreateEnrollmentAction::class),
            confirmEnrollmentAction: app(ConfirmEnrollmentAction::class),
        );
    }

    private function makeFawaterakGateway(?PaymentGateway $gatewayRecord): PaymentGatewayInterface
    {
        $credentials = (array) ($gatewayRecord?->credentials ?? []);
        $apiKey = $credentials['api_key'] ?? config('payment.fawaterak.api_key');

        if (! $apiKey) {
            throw new InvalidArgumentException('Fawaterak api_key is not configured.');
        }

        $sandbox = array_key_exists('sandbox', $credentials)
            ? filter_var($credentials['sandbox'], FILTER_VALIDATE_BOOLEAN)
            : (array_key_exists('sand_box', $credentials)
                ? filter_var($credentials['sand_box'], FILTER_VALIDATE_BOOLEAN)
                : ($gatewayRecord?->mode === 'test' || config('payment.fawaterak.sandbox', false)));

        $redirections = [
            'successUrl' => $credentials['success_url'] ?? config('payment.fawaterak.redirections.successUrl'),
            'failUrl' => $credentials['fail_url'] ?? config('payment.fawaterak.redirections.failUrl'),
            'pendingUrl' => $credentials['pending_url'] ?? config('payment.fawaterak.redirections.pendingUrl'),
            'webhookUrl' => $credentials['webhook_url'] ?? config('payment.fawaterak.redirections.webhookUrl'),
        ];

        return new FawaterakGateway(
            apiKey: $apiKey,
            redirectionUrls: array_filter($redirections),
            sandbox: (bool) $sandbox,
            createEnrollmentAction: app(CreateEnrollmentAction::class),
        );
    }
}
