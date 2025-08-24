<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_exists_in_database()
    {
        $user = User::create([
            'name' => 'shukrisenawi',
            'email' => 'shukrisenawi@gmail.com',
            'password' => Hash::make('123'),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'shukrisenawi',
            'email' => 'shukrisenawi@gmail.com',
        ]);

        $this->assertTrue(Hash::check('123', $user->password));
    }

    /** @test */
    public function user_table_has_required_columns()
    {
        $user = User::create([
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->assertNotNull($user->id);
        $this->assertNotNull($user->name);
        $this->assertNotNull($user->email);
        $this->assertNotNull($user->password);
        $this->assertNotNull($user->created_at);
        $this->assertNotNull($user->updated_at);
    }
}
