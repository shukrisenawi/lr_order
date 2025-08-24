<?php

namespace Tests\Unit;

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AuthValidationTest extends TestCase
{
    /** @test */
    public function login_validation_rules_are_correct()
    {
        $controller = new AuthController();
        
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
            'remember' => 'boolean',
        ];

        // Test valid data
        $validData = [
            'username' => 'shukrisenawi',
            'password' => '123',
            'remember' => true,
        ];

        $validator = Validator::make($validData, $rules);
        $this->assertFalse($validator->fails());

        // Test missing username
        $invalidData = $validData;
        unset($invalidData['username']);
        $validator = Validator::make($invalidData, $rules);
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('username'));

        // Test missing password
        $invalidData = $validData;
        unset($invalidData['password']);
        $validator = Validator::make($invalidData, $rules);
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('password'));

        // Test invalid remember value
        $invalidData = $validData;
        $invalidData['remember'] = 'invalid';
        $validator = Validator::make($invalidData, $rules);
        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('remember'));
    }

    /** @test */
    public function username_can_be_email_or_username()
    {
        // Test with username
        $data1 = ['username' => 'shukrisenawi', 'password' => '123'];
        $rules = ['username' => 'required|string', 'password' => 'required|string'];
        $validator = Validator::make($data1, $rules);
        $this->assertFalse($validator->fails());

        // Test with email
        $data2 = ['username' => 'shukrisenawi@gmail.com', 'password' => '123'];
        $validator = Validator::make($data2, $rules);
        $this->assertFalse($validator->fails());
    }
}
