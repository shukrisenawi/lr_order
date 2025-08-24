<?php
require_once 'vendor/autoload.php';
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
    
    // Check password
    echo "Password '851203sa' matches: " . (Hash::check('851203sa', $user->password) ? "Yes" : "No") . "\n";
    echo "Password '123' matches: " . (Hash::check('123', $user->password) ? "Yes" : "No") . "\n";
} else {
    echo "User not found\n";
}
?>
