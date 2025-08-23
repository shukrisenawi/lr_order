<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BisnesController;

// Home route
Route::get('/', function () {
    return view('welcome');
});

// Test route
Route::get('/test-login', function () {
    return view('test-login');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Business Management Routes
    Route::resource('bisnes', BisnesController::class);
    Route::resource('produk', 'App\Http\Controllers\ProdukController');
    Route::resource('gambar', 'App\Http\Controllers\GambarController');

    // Customer Management Routes
    Route::resource('prospek', 'App\Http\Controllers\ProspekController');
    Route::resource('prospek-alamat', 'App\Http\Controllers\ProspekAlamatController');
    Route::resource('prospek-buy', 'App\Http\Controllers\ProspekBuyController');
});

// API routes
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/user', function () {
        return auth()->user();
    });
});
