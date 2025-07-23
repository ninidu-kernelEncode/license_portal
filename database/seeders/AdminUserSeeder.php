<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'ninidu@kernelencode.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('1234'),
                'email_verified_at' => now(),
            ]
        );
    }
}
