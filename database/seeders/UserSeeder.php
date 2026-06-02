<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::withoutEvents(function () {
            $user1 = User::factory()->create([
                'name' => 'superadmin',
                'email' => 'superadmin@admin.com',
                'password' => Hash::make('12345678'),
            ]);
            $user1->username = $user1->id.rand(100000, 999999);
            $user1->saveQuietly();
            $user1->assignRole('superadmin');

            $user2 = User::factory()->create([
                'name' => 'easyta3lim',
                'email' => 'easyta3lim@gmail.com',
                'password' => Hash::make('Nody2572005#'),
            ]);
            $user2->username = $user2->id.rand(100000, 999999);
            $user2->saveQuietly();
            $user2->assignRole('superadmin');
        });
    }
}
