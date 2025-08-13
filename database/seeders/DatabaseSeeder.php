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
        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'name' => 'Super Admin',
                'country' => 'Bangladesh',
                'role' => 1,
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]
        );
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'first_name' => 'UserFirst' . $i,
                'last_name' => 'UserLast' . $i,
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'country' => 'Bangladesh',
                'role' => 0,
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
