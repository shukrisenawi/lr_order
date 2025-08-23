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
    Route::get('/dashboard', function () {
        return view('dashboard-livewire');
    })->name('dashboard');

    // Business Management Routes
    Route::get('/bisnes', function () {
        return view('bisnes-livewire');
    })->name('bisnes.index');
    Route::resource('bisnes', BisnesController::class)->except(['index']);
    Route::get('/produk', function () {
        return view('produk-livewire');
    })->name('produk.index');
    Route::resource('produk', 'App\Http\Controllers\ProdukController')->except(['index']);

    Route::resource('gambar', 'App\Http\Controllers\GambarController');

    // Customer Management Routes
    Route::get('/prospek', function () {
        return view('prospek-livewire');
    })->name('prospek.index');
    Route::resource('prospek', 'App\Http\Controllers\ProspekController')->except(['index']);

    Route::resource('prospek-alamat', 'App\Http\Controllers\ProspekAlamatController');

    Route::get('/prospek-buy', function () {
        return view('prospek-buy-livewire');
    })->name('prospek-buy.index');
    Route::resource('prospek-buy', 'App\Http\Controllers\ProspekBuyController')->except(['index']);
});

// API routes
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/user', function () {
        return auth()->user();
    });
});
