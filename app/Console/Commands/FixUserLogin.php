<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class FixUserLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-user-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix user login by verifying email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('email', 'shukrisenawi@gmail.com')->first();
        
        if ($user) {
            $this->info("User found: {$user->name}");
            $this->info("Email verified: " . ($user->email_verified_at ? "Yes" : "No"));
            
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
                $user->save();
                $this->info("Email verification updated");
            }
            
            $this->info("Login should now work!");
        } else {
            $this->error("User not found");
        }
    }
}
