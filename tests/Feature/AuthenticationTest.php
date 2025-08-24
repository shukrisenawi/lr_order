<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test user
        User::create([
            'name' => 'shukrisenawi',
            'email' => 'shukrisenawi@gmail.com',
            'password' => Hash::make('password123'),
        ]);
    }

    #[Test]
    public function user_can_login_with_username()
    {
        $response = $this->post('/login', [
            'username' => 'shukrisenawi',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    #[Test]
    public function user_can_login_with_email()
    {
        $response = $this->post('/login', [
            'username' => 'shukrisenawi@gmail.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    #[Test]
    public function user_cannot_login_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'username' => 'shukrisenawi',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    #[Test]
    public function login_requires_username_and_password()
    {
        $response = $this->post('/login', []);

        $response->assertSessionHasErrors(['username', 'password']);
    }

    #[Test]
    public function user_can_logout()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    #[Test]
    public function login_form_is_accessible()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login-new');
    }

    #[Test]
    public function user_is_redirected_to_dashboard_when_already_logged_in()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->get('/login');

        $response->assertRedirect('/dashboard');
    }

    #[Test]
    public function rate_limiting_blocks_multiple_failed_attempts()
    {
        // Make 5 failed attempts
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'username' => 'shukrisenawi',
                'password' => 'wrongpassword',
            ]);
        }

        // 6th attempt should be blocked
        $response = $this->post('/login', [
            'username' => 'shukrisenawi',
            'password' => 'password123', // Even with correct password
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertStringContainsString('Too many login attempts', session('errors')->first('username'));
    }

    #[Test]
    public function remember_me_functionality_works()
    {
        $response = $this->post('/login', [
            'username' => 'shukrisenawi',
            'password' => 'password123',
            'remember' => true,
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        
        // Check if remember cookie is set
        $response->assertCookie('remember_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
    }

    #[Test]
    public function user_is_redirected_to_intended_page_after_login()
    {
        // Try to access protected route
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        // Login and check if redirected to intended page
        $response = $this->post('/login', [
            'username' => 'shukrisenawi',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
    }
}
