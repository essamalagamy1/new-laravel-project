<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);
        $this->call(PaymentGatewaySeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(SiteSettingSeeder::class);
        $this->call(UserSeeder::class);
    }
}
