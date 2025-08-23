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
        User::create([
            'name' => 'shukrisenawi',
            'email' => 'shukrisenawi@gmail.com',
            'password' => Hash::make('123'),
        ]);
    }
}
