<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        $gateways = [
            [
                'name' => 'manual_transfer',
                'slug' => 'manual_transfer',
                'credentials' => [],
                'is_active' => true,
                'is_default' => true,
                'currency' => 'EGP',
                'mode' => 'live',
                'sort_order' => 0,
            ],
            [
                'name' => 'free_payment',
                'slug' => 'free_payment',
                'credentials' => [],
                'is_active' => true,
                'is_default' => false,
                'currency' => 'EGP',
                'mode' => 'live',
                'sort_order' => 0,
            ],
            [
                'name' => 'fawaterak',
                'slug' => 'fawaterak',
                'credentials' => [
                    'api_key' => 'd83a5d07aaeb8442dcbe259e6dae80a3f2e21a3a581e1a5acd',
                    'sand_box' => true,
                    'success_url' => config('app.url').'/api/v1/payment/success',
                    'fail_url' => config('app.url').'/api/v1/payment/failure',
                    'pending_url' => config('app.url').'/api/v1/payment/pending',
                    'webhook_url' => config('app.url').'/api/v1/payment/webhook',
                ],
                'is_active' => true,
                'is_default' => false,
                'currency' => 'EGP',
                'mode' => 'test',
                'sort_order' => 1,
            ],

        ];

        foreach ($gateways as $gateway) {
            PaymentGateway::updateOrCreate(
                ['slug' => $gateway['slug']],
                $gateway
            );
        }
    }
}
