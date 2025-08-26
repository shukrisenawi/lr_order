<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BisnesController;
use App\Models\Bisnes;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;

// Home route
Route::get('/', function () {
    return redirect()->route('login');
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
    $user = User::findOrFail($request->id);

    if (!hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
        throw new AuthorizationException;
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
    Auth::loginUsingId(1);
    return redirect('/dashboard');
})->name('quick-login');

// Switch business route
Route::get('/switch-bisnes/{bisnes}', function ($bisnes = 0) {

    // Verify user owns this business
    $bisnesSelect = Bisnes::find($bisnes);

    if ($bisnesSelect && $bisnesSelect->user_id !== auth()->id()) {
        abort(403);
    }
    $idSelect = $bisnesSelect ? $bisnesSelect->id : 0;
    // Store selected business in session
    session(['selected_bisnes_id' => $idSelect]);
    if ($bisnes)
        return redirect()->back()->with('success', 'Bisnes ditukar kepada: ' . $bisnesSelect->nama_bines);
    else
        return redirect()->back()->with('success', 'Semua bisnes dibuka.');
})->name('switch-bisnes')->middleware('auth');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard-livewire');
    })->name('dashboard');

    // Data Table Route
    Route::get('/data-table', function () {
        return view('data-table-livewire');
    })->name('data-table');

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
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/api-tokens', [SettingsController::class, 'apiTokens'])->name('api-tokens');
        Route::post('/api-tokens', [SettingsController::class, 'createApiToken'])->name('api-tokens.create');
        Route::delete('/api-tokens/{token}', [SettingsController::class, 'deleteApiToken'])->name('api-tokens.delete');
        Route::get('/api-documentation', [SettingsController::class, 'apiDocumentation'])->name('api-documentation');
        Route::get('/jt-express', 'App\Http\Controllers\JTExpressController@index')->name('jt-express');
        Route::post('/jt-express/send-order', 'App\Http\Controllers\JTExpressController@sendOrder')->name('jt-express.send-order');
    });
});

// Image routes for web interface (no authentication required)
Route::prefix('images')->name('web.image.')->group(function () {
    Route::get('/business/{filename}', [ImageController::class, 'businessImage'])->name('business');
    Route::get('/gallery/{filename}', [ImageController::class, 'galleryImage'])->name('gallery');
    Route::get('/serve/{path}', [ImageController::class, 'serveImage'])->name('serve');
});

// API routes
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/user', function () {
        return auth()->user();
    });
});
