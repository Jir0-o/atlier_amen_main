<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔐 Create Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'name' => 'Super Admin',
                'country' => 'Bangladesh',
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]
        );

        // 👥 Create 10 dummy users
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'first_name' => 'UserFirst' . $i,
                'last_name' => 'UserLast' . $i,
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'country' => 'Bangladesh',
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
