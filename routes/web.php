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

// Quick login for testing
Route::get('/quick-login', function () {
    \Illuminate\Support\Facades\Auth::loginUsingId(1);
    return redirect('/dashboard');
})->name('quick-login');

// Switch business route
Route::get('/switch-bisnes/{bisnes}', function (\App\Models\Bisnes $bisnes) {
    // Verify user owns this business
    if ($bisnes->user_id !== auth()->id()) {
        abort(403);
    }

    // Store selected business in session
    session(['selected_bisnes_id' => $bisnes->id]);

    return redirect()->back()->with('success', 'Bisnes ditukar kepada: ' . $bisnes->nama_bines);
})->name('switch-bisnes')->middleware('auth');

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

    // Settings routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SettingsController::class, 'index'])->name('index');
        Route::get('/api-tokens', [\App\Http\Controllers\SettingsController::class, 'apiTokens'])->name('api-tokens');
        Route::post('/api-tokens', [\App\Http\Controllers\SettingsController::class, 'createApiToken'])->name('api-tokens.create');
        Route::delete('/api-tokens/{token}', [\App\Http\Controllers\SettingsController::class, 'deleteApiToken'])->name('api-tokens.delete');
        Route::get('/api-documentation', [\App\Http\Controllers\SettingsController::class, 'apiDocumentation'])->name('api-documentation');
    });
});

// API routes
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/user', function () {
        return auth()->user();
    });
});
