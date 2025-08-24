<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class QuickLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test user
        User::create([
            'name' => 'shukrisenawi',
            'email' => 'shukrisenawi@gmail.com',
            'password' => Hash::make('123'),
        ]);
    }

    /** @test */
    public function quick_login_works_with_valid_credentials()
    {
        $response = $this->get('/quick-login');

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    /** @test */
    public function quick_login_redirects_to_login_if_no_user_exists()
    {
        // Delete all users
        User::truncate();

        $response = $this->get('/quick-login');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /** @test */
    public function quick_login_uses_first_available_user()
    {
        // Create additional users
        User::create([
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->get('/quick-login');

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        
        // Should login as the first user (shukrisenawi)
        $this->assertEquals('shukrisenawi', auth()->user()->name);
    }
}
