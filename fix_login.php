<?php
require_once 'vendor/autoload.php';
use App\Models\User;

// Get the user
$user = User::where('email', 'shukrisenawi@gmail.com')->first();

if ($user) {
    echo "User found: " . $user->name . "\n";
    echo "Email verified: " . ($user->email_verified_at ? "Yes" : "No") . "\n";
    
    // Verify email
    if (!$user->email_verified_at) {
        $user->email_verified_at = now();
        $user->save();
        echo "Email verification updated\n";
    }
    
    echo "Login should now work!\n";
} else {
    echo "User not found\n";
}
