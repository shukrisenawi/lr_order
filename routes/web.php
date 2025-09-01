<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BisnesController;
use App\Models\Bisnes;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

// Test invoice PDF route
Route::get('/test-invoice-pdf', function () {
    // Create a sample invoice data structure
    $invoice = (object) [
        'id' => 1,
        'invoice_no' => 'INV001',
        'created_at' => now(),
        'nama_penerima' => 'John Doe',
        'alamat' => '123 Main Street, Kuala Lumpur, 50000',
        'no_tel' => '012-345-6789',
        'kurier' => 'J&T Express',
        'catatan' => 'Thank you for your business! Please make payment within 30 days.',
        'jumlah' => 105.93,
        'bisnes' => (object) [
            'nama_bisnes' => 'Your Company Name'
        ],
        'items' => collect([
            (object) [
                'product_name' => 'Line Item',
                'kuantiti' => 1,
                'harga' => 99.00,
                'total' => 99.00,
                'produk_custom' => 'Sample product description'
            ]
        ])
    ];

    return view('invoice.view-invoice', compact('invoice'));
})->name('test-invoice-pdf');

// Test Browsershot PDF route
Route::get('/test-browsershot-pdf', function () {
    try {
        // Test with a simple HTML content first
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Test PDF</title>
            <style>
                body { font-family: Arial, sans-serif; padding: 20px; }
                .header { color: #333; font-size: 24px; margin-bottom: 20px; }
                .content { font-size: 14px; line-height: 1.6; }
            </style>
        </head>
        <body>
            <div class="header">Test PDF Generation</div>
            <div class="content">
                <p>This is a test PDF generated using Spatie Browsershot.</p>
                <p>Invoice Number: INV001</p>
                <p>Customer: John Doe</p>
                <p>Amount: RM105.93</p>
                <p>Date: ' . now()->format('d M Y') . '</p>
            </div>
        </body>
        </html>';

        // Generate PDF using Browsershot with HTML content
        $pdf = \Spatie\Browsershot\Browsershot::html($html)
            ->setOption('args', ['--no-sandbox', '--disable-setuid-sandbox'])
            ->format('A4')
            ->margins(10, 10, 10, 10)
            ->showBackground()
            ->pdf();

        // Return PDF as download
        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="test-browsershot.pdf"');
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'PDF generation failed',
            'message' => $e->getMessage()
        ], 500);
    }
})->name('test-browsershot-pdf');

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

    // AI Approval Route
    Route::get('/ai', function () {
        return view('ai-livewire');
    })->name('ai');

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

    Route::get('/jadual', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('jadual-livewire');
    })->name('jadual.index');
    Route::post('/jadual/{jadual}', [ProspekController::class, 'update'])->name('jadual.update');
    Route::resource('jadual', ProspekController::class)->except(['index']);


    Route::get('/customer', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('customer-livewire');
    })->name('customer.index');
    Route::get('/customer/generate', [CustomerController::class, 'generate'])->name('customer.generate');
    Route::post('/customer/generate-data', [CustomerController::class, 'generateData'])->name('customer.generate-data');
    Route::resource('customer', CustomerController::class)->except(['index']);

    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/view-invoice/{invoice?}', [InvoiceController::class, 'viewInvoice'])->name('invoice.view-invoice');
    Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::get('/invoice/create/{customer}', [InvoiceController::class, 'create'])->name('invoice.customer');
    Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/invoice/{invoice}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/invoice/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/invoice/{invoice}', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::delete('/invoice/{invoice}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    Route::get('/invoice/{invoice}/pdf', [InvoiceController::class, 'generatePdf'])->name('invoice.pdf');
    Route::get('/invoice/{invoice}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('invoice.download-pdf');

    Route::get('/tracking', function () {
        return view('tracking-livewire');
    })->name('tracking.index');
    Route::resource('tracking', TrackingController::class)->except(['index']);
    Route::post('/tracking/{tracking}', [TrackingController::class, 'update'])->name('tracking.update');
    Route::post('/tracking/{tracking}/create-shipment', [TrackingController::class, 'createShipment'])->name('tracking.create-shipment');
    Route::get('/tracking/{tracking}/track-shipment', [TrackingController::class, 'trackShipment'])->name('tracking.track-shipment');

    // Jadual Pengajian Routes
    Route::get('/jadual-pengajian', function () {
        return view('jadual-pengajian-livewire');
    })->name('jadual-pengajian.index');
    Route::get('/jadual-pengajian/create', function () {
        return view('jadual-pengajian-create');
    })->name('jadual-pengajian.create');
    Route::get('/jadual-pengajian/{jadual}/edit', function ($jadual) {
        $jadual = \App\Models\JadualPengajian::findOrFail($jadual);
        return view('jadual-pengajian-edit', compact('jadual'));
    })->name('jadual-pengajian.edit');
    Route::get('/jadual-pengajian/{jadual}', function ($jadual) {
        $jadual = \App\Models\JadualPengajian::findOrFail($jadual);
        return view('jadual-pengajian-show', compact('jadual'));
    })->name('jadual-pengajian.show');

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

    // Profile routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile/avatar', [App\Http\Controllers\ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');
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
