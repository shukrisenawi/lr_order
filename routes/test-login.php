<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Test route for new login page
Route::get('/test-login', function () {
    return view('auth.login-new');
});

// Test route for new login page with custom styles
Route::get('/test-login-styled', function () {
    return view('auth.login-new');
});

// Handle login form submission
Route::post('/test-login', function (Request $request) {
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json(['success' => true, 'message' => 'Login successful']);
    }

    return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
});
