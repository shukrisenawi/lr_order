<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test user credentials
$username = 'shukrisenawi';
$password = '123';

echo "Testing login credentials...\n";
echo "Username: $username\n";
echo "Password: $password\n\n";

// Find user by name
$user = User::where('name', $username)->first();

if ($user) {
    echo "✓ User found in database\n";
    echo "User ID: " . $user->id . "\n";
    echo "User Name: " . $user->name . "\n";
    echo "User Email: " . $user->email . "\n";
    
    // Check password
    if (Hash::check($password, $user->password)) {
        echo "✓ Password is correct!\n";
        echo "Login should work!\n";
    } else {
        echo "✗ Password is incorrect!\n";
        echo "Stored hash: " . $user->password . "\n";
        echo "Expected hash for '$password': " . Hash::make($password) . "\n";
    }
} else {
    echo "✗ User not found in database\n";
    echo "Available users:\n";
    $users = User::all();
    foreach ($users as $u) {
        echo "- ID: {$u->id}, Name: {$u->name}, Email: {$u->email}\n";
    }
}
