<?php

namespace App\Providers;

use App\Services\Payment\PaymentGatewayFactory;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(PaymentGatewayFactory::class, fn () => new PaymentGatewayFactory);
    }
}
