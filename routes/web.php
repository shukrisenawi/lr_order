<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = \App\Models\User::findOrFail($request->id);
    
    if (!hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
        throw new \Illuminate\Auth\Access\AuthorizationException;
    }
    
    if ($user->hasVerifiedEmail()) {
        return redirect()->intended('/dashboard');
    }
    
    if ($user->markEmailAsVerified()) {
        event(new \Illuminate\Auth\Events\Verified($user));
    }
    
    return redirect()->intended('/dashboard')->with('success', 'Emel berjaya disahkan!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Pautan pengesahan telah dihantar ke emel anda!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

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

// Image routes for web interface (no authentication required)
Route::prefix('images')->name('web.image.')->group(function () {
    Route::get('/business/{filename}', [\App\Http\Controllers\ImageController::class, 'businessImage'])->name('business');
    Route::get('/gallery/{filename}', [\App\Http\Controllers\ImageController::class, 'galleryImage'])->name('gallery');
    Route::get('/serve/{path}', [\App\Http\Controllers\ImageController::class, 'serveImage'])->name('serve');
});

// API routes
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/user', function () {
        return auth()->user();
    });
});
