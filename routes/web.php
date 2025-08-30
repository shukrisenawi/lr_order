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
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GambarController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\IklanController;
use App\Http\Controllers\ProspekController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TrackingController;
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
Route::get('/switch-bisnes/{bisnes}', function (Bisnes $bisnes) {


    if ($bisnes->user_id !== auth()->id()) {
        abort(403);
    }
    session(['selected_bisnes_id' => $bisnes->id]);
    return redirect()->back();
    // if ($bisnes)
    //     return redirect()->back()->with('success', 'Bisnes ditukar kepada: ' . $bisnes->nama_bisnes);
    // else
    //     return redirect()->back()->with('success', 'Senarai Bisnes.');
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
    Route::get('/bisnes/summary/{bisnes}', [BisnesController::class, 'summary'])->name('bisnes.summary');
    Route::resource('bisnes', BisnesController::class)->except(['index']);

    Route::get('/produk', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('produk-livewire');
    })->name('produk.index');
    Route::resource('produk', ProdukController::class)->except(['index']);
    Route::post('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');

    Route::get('/iklan', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('iklan-livewire');
    })->name('iklan.index');
    Route::resource('iklan', IklanController::class)->except(['index']);
    Route::post('/iklan/{iklan}', [IklanController::class, 'update'])->name('iklan.update');

    Route::post('/gambar/{gambar}', [GambarController::class, 'update'])->name('gambar.update');

    Route::resource('gambar', GambarController::class);

    // Customer Management Routes
    Route::get('/prospek', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('prospek-livewire');
    })->name('prospek.index');
    Route::post('/prospek/{prospek}', [ProspekController::class, 'update'])->name('prospek.update');
    Route::resource('prospek', ProspekController::class)->except(['index']);

    Route::get('/customer', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('customer-livewire');
    })->name('customer.index');
    Route::get('/customer/generate', [CustomerController::class, 'generate'])->name('customer.generate');
    Route::post('/customer/generate-data', [CustomerController::class, 'generateData'])->name('customer.generate-data');
    Route::resource('customer', CustomerController::class)->except(['index']);

    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::get('/invoice/create/{customer}', [InvoiceController::class, 'create'])->name('invoice.customer');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/{invoice}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/invoice/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoice/{invoice}', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('/invoice/{invoice}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::get('/invoice/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('invoice.pdf');

    Route::get('/tracking', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('tracking-livewire');
    })->name('tracking.index');
    Route::resource('tracking', TrackingController::class)->except(['index']);
    Route::post('/tracking/{tracking}', [TrackingController::class, 'update'])->name('tracking.update');

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
