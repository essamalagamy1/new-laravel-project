<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        // Fixed discount coupons
        Coupon::create([
            'code' => 'WELCOME50',
            'type' => 'fixed',
            'value' => 50.00,
            'min_order_value' => 200.00,
            'max_discount' => 50.00,
            'usage_limit' => 100,
            'expiry_date' => now()->addMonths(3),
        ]);

        Coupon::create([
            'code' => 'SAVE100',
            'type' => 'fixed',
            'value' => 100.00,
            'min_order_value' => 500.00,
            'max_discount' => 100.00,
            'usage_limit' => 50,
            'expiry_date' => now()->addMonths(6),
        ]);

        // Percentage discount coupons
        Coupon::create([
            'code' => 'DISCOUNT10',
            'type' => 'percent',
            'value' => 10.00,
            'min_order_value' => 100.00,
            'max_discount' => 200.00,
            'usage_limit' => 200,
            'expiry_date' => now()->addYear(),
        ]);

        Coupon::create([
            'code' => 'SALE20',
            'type' => 'percent',
            'value' => 20.00,
            'min_order_value' => 300.00,
            'max_discount' => 500.00,
            'usage_limit' => 150,
            'expiry_date' => now()->addMonths(2),
        ]);

        Coupon::create([
            'code' => 'MEGA25',
            'type' => 'percent',
            'value' => 25.00,
            'min_order_value' => 1000.00,
            'max_discount' => 1000.00,
            'usage_limit' => null, // Unlimited
            'expiry_date' => now()->addMonths(12),
        ]);
    }
}
