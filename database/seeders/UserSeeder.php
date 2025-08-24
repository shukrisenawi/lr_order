<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the specific user with username shukrisenawi and password 123
        User::updateOrCreate(
            ['email' => 'shukrisenawi@gmail.com'],
            [
                'name' => 'shukrisenawi',
                'password' => Hash::make('851203sa'),
                'email_verified_at' => now(),
            ]
        );
    }
}
