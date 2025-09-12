<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScanCulaController;
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
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\DB;

// Home route
Route::get('/', function () {
    return redirect()->route('login');
});

// Test route
Route::get('/test-login', function () {
    return view('test-login');
});

// Test expired session route
Route::get('/test-expired', function () {
    abort(419, 'Page Expired');
})->middleware('auth');

// Test SweetAlert route
Route::get('/test-sweetalert', function () {
    return redirect('/dashboard')->with('success', 'SweetAlert 2 berfungsi dengan baik!');
})->name('test-sweetalert');

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
    $user = Auth::user();

    // Check if user has access to this business
    $hasAccess = false;

    // Admin can access all businesses
    if ($user->role === 'admin') {
        $hasAccess = true;
    } else {
        // Check if user has access via pivot table or owns the business
        $hasAccess = $user->bisnes()->where('bisnes.id', $bisnes->id)->exists() ||
                    $bisnes->user_id === $user->id;
    }

    if (!$hasAccess) {
        abort(403, 'Anda tidak mempunyai akses ke bisnes ini.');
    }

    session(['selected_bisnes_id' => $bisnes->id]);
    return redirect()->back();
})->name('switch-bisnes')->middleware('auth');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // Get businesses user has access to (owned + assigned via pivot table)
        $userBisnes = $user->bisnes()->get();

        // If user is admin, also include businesses they own
        if ($user->role === 'admin') {
            $ownedBisnes = Bisnes::where('user_id', $user->id)->get();
            $userBisnes = $userBisnes->merge($ownedBisnes)->unique('id');
        }

        // If no businesses accessible, redirect appropriately
        if ($userBisnes->isEmpty()) {
            if ($user->role === 'admin') {
                return redirect()->route('bisnes.create')->with('info', 'Sila buat bisnes terlebih dahulu sebelum mengakses dashboard.');
            } else {
                return redirect()->route('profile.edit')->with('warning', 'Anda belum diberi akses ke mana-mana bisnes. Sila hubungi admin.');
            }
        }

        // If no business selected, auto-select the first accessible business
        if (empty(session('selected_bisnes_id'))) {
            $firstBisnes = $userBisnes->first();
            session(['selected_bisnes_id' => $firstBisnes->id]);
        }

        // Verify selected business is still accessible
        $selectedBisnesId = session('selected_bisnes_id');
        $selectedBisnes = $userBisnes->find($selectedBisnesId);

        if (!$selectedBisnes) {
            // Selected business no longer accessible, select first available
            $firstBisnes = $userBisnes->first();
            session(['selected_bisnes_id' => $firstBisnes->id]);
            $selectedBisnesId = $firstBisnes->id;
        }

        switch ($selectedBisnesId) {
            case 1:
                return view('dashboard-livewire');
            case 2:
                return view('dashboard-livewire');
            case 3:
                return view('dashboard-bisnes3-livewire');
            case 4:
                return view('dashboard-bisnes4-livewire');
            default:
                return view('dashboard-livewire');
        }
    })->name('dashboard');

    // Data Table Route
    Route::get('/data-table', function () {
        return view('data-table-livewire');
    })->name('data-table');

    // AI Approval Route
    Route::get('/ai', function () {
        return view('ai-livewire');
    })->name('ai');

    // Analisa AI Route
    Route::get('/analisa-ai', function () {
        return view('analisa-ai-livewire');
    })->name('analisa-ai.index');

    // ChatGPT Route
    Route::get('/chatgpt', function () {
        return view('chat-gpt-livewire');
    })->name('chatgpt.index');

    // Scan Cula Routes
    Route::resource('scan-cula', ScanCulaController::class);

    // Business Management Routes
    Route::get('/bisnes', function () {
        // Check if user is admin, if not redirect to dashboard
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('warning', 'Anda tidak mempunyai akses ke menu bisnes.');
        }
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

    // Data Penduduk Routes
    Route::get('/data-penduduk', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('data-penduduk-livewire');
    })->name('data-penduduk.index');
    Route::get('/data-penduduk/create', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('data-penduduk-create');
    })->name('data-penduduk.create');
    Route::get('/data-penduduk/{dataPenduduk}/edit', function ($dataPenduduk) {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        $dataPenduduk = \App\Models\DataPenduduk::findOrFail($dataPenduduk);
        return view('data-penduduk-edit', compact('dataPenduduk'));
    })->name('data-penduduk.edit');
    Route::get('/data-penduduk/{dataPenduduk}', function ($dataPenduduk) {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        $dataPenduduk = \App\Models\DataPenduduk::findOrFail($dataPenduduk);
        return view('data-penduduk-show', compact('dataPenduduk'));
    })->name('data-penduduk.show');

    // Kod Cula Routes
    Route::get('/kod-cula', function () {
        if (session('selected_bisnes_id') != 4) {
            return redirect()->route('dashboard');
        }
        return view('kod-cula-livewire');
    })->name('kod-cula.index');

    // Anak Khariah Routes
    Route::get('/anak-khariah', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('anak-khariah-livewire');
    })->name('anak-khariah.index');
    Route::get('/anak-khariah/add-to-kumpulan', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('anak-khariah-add-to-kumpulan');
    })->name('anak-khariah.add-to-kumpulan');
    Route::get('/anak-khariah/create', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('anak-khariah-create');
    })->name('anak-khariah.create');
    Route::get('/anak-khariah/{anakKhariah}/edit', function ($anakKhariah) {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        $anakKhariah = \App\Models\AnakKhariah::findOrFail($anakKhariah);
        return view('anak-khariah-edit', compact('anakKhariah'));
    })->name('anak-khariah.edit');
    Route::get('/anak-khariah/{anakKhariah}', function ($anakKhariah) {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        $anakKhariah = \App\Models\AnakKhariah::findOrFail($anakKhariah);
        return view('anak-khariah-show', compact('anakKhariah'));
    })->name('anak-khariah.show');

    // Kumpulan Routes
    Route::get('/kumpulan', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('kumpulan-livewire');
    })->name('kumpulan.index');
    Route::get('/kumpulan/create', function () {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        return view('kumpulan-create');
    })->name('kumpulan.create');
    Route::get('/kumpulan/{kumpulan}/edit', function ($kumpulan) {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        $kumpulan = \App\Models\Kumpulan::findOrFail($kumpulan);
        return view('kumpulan-edit', compact('kumpulan'));
    })->name('kumpulan.edit');
    Route::get('/kumpulan/{kumpulan}', function ($kumpulan) {
        if (empty(session('selected_bisnes_id')))
            return redirect()->route('bisnes.index');
        $kumpulan = \App\Models\Kumpulan::with('anakKhariahs')->findOrFail($kumpulan);
        return view('kumpulan-show', compact('kumpulan'));
    })->name('kumpulan.show');

    // Tenaga Pengajar Routes
    Route::get('/tenaga-pengajar', function () {
        return view('tenaga-pengajar-livewire');
    })->name('tenaga-pengajar.index');
    Route::get('/tenaga-pengajar/create', function () {
        return view('tenaga-pengajar-create');
    })->name('tenaga-pengajar.create');
    Route::get('/tenaga-pengajar/{tenagaPengajar}/edit', function ($tenagaPengajar) {
        $tenagaPengajar = \App\Models\TenagaPengajar::findOrFail($tenagaPengajar);
        return view('tenaga-pengajar-edit', compact('tenagaPengajar'));
    })->name('tenaga-pengajar.edit');
    Route::get('/tenaga-pengajar/{tenagaPengajar}', function ($tenagaPengajar) {
        $tenagaPengajar = \App\Models\TenagaPengajar::findOrFail($tenagaPengajar);
        return view('tenaga-pengajar-show', compact('tenagaPengajar'));
    })->name('tenaga-pengajar.show');

    // Kitab Pengajian Routes
    Route::get('/kitab-pengajian', function () {
        return view('kitab-pengajian-livewire');
    })->name('kitab-pengajian.index');
    Route::get('/kitab-pengajian/create', function () {
        return view('kitab-pengajian-create');
    })->name('kitab-pengajian.create');
    Route::get('/kitab-pengajian/{kitabPengajian}/edit', function ($kitabPengajian) {
        $kitabPengajian = \App\Models\KitabPengajian::findOrFail($kitabPengajian);
        return view('kitab-pengajian-edit', compact('kitabPengajian'));
    })->name('kitab-pengajian.edit');
    Route::get('/kitab-pengajian/{kitabPengajian}', function ($kitabPengajian) {
        $kitabPengajian = \App\Models\KitabPengajian::findOrFail($kitabPengajian);
        return view('kitab-pengajian-show', compact('kitabPengajian'));
    })->name('kitab-pengajian.show');

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
    Route::get('/invoice/{invoice}/print', [InvoiceController::class, 'viewInvoice'])->name('invoice.print');

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

    // Waktu Solat Routes
    Route::get('/waktu-solat', function () {
        return view('waktu-solat-livewire');
    })->name('waktu-solat.index');
    Route::get('/waktu-solat/create', function () {
        return view('waktu-solat-create');
    })->name('waktu-solat.create');
    Route::get('/waktu-solat/{waktu}/edit', function ($waktu) {
        $waktu = \App\Models\WaktuSolat::findOrFail($waktu);
        return view('waktu-solat-edit', compact('waktu'));
    })->name('waktu-solat.edit');
    Route::get('/waktu-solat/{waktu}', function ($waktu) {
        $waktu = \App\Models\WaktuSolat::findOrFail($waktu);
        return view('waktu-solat-show', compact('waktu'));
    })->name('waktu-solat.show');

    // Pengajian Routes
    Route::get('/pengajian', function () {
        return view('pengajian-livewire');
    })->name('pengajian.index');
    Route::get('/pengajian/create', function () {
        return view('pengajian-create');
    })->name('pengajian.create');
    Route::get('/pengajian/{pengajian}/edit', function ($pengajian) {
        $pengajian = \App\Models\Pengajian::findOrFail($pengajian);
        return view('pengajian-edit', compact('pengajian'));
    })->name('pengajian.edit');
    Route::get('/pengajian/{pengajian}', function ($pengajian) {
        $pengajian = \App\Models\Pengajian::findOrFail($pengajian);
        return view('pengajian-show', compact('pengajian'));
    })->name('pengajian.show');

    // Program Routes
    Route::get('/program', function () {
        return view('program-livewire');
    })->name('program.index');
    Route::get('/program/create', function () {
        return view('program-create');
    })->name('program.create');
    Route::get('/program/{program}/edit', function ($program) {
        $program = \App\Models\Program::findOrFail($program);
        return view('program-edit', compact('program'));
    })->name('program.edit');
    Route::get('/program/{program}', function ($program) {
        $program = \App\Models\Program::findOrFail($program);
        return view('program-show', compact('program'));
    })->name('program.show');

    // Pengumuman Routes
    Route::get('/pengumuman', function () {
        return view('pengumuman-livewire');
    })->name('pengumuman.index');
    Route::get('/pengumuman/create', function () {
        return view('pengumuman-create');
    })->name('pengumuman.create');
    Route::get('/pengumuman/{pengumuman}/edit', function ($pengumuman) {
        $pengumuman = \App\Models\Pengumuman::findOrFail($pengumuman);
        return view('pengumuman-edit', compact('pengumuman'));
    })->name('pengumuman.edit');
    Route::get('/pengumuman/{pengumuman}', function ($pengumuman) {
        $pengumuman = \App\Models\Pengumuman::findOrFail($pengumuman);
        return view('pengumuman-show', compact('pengumuman'));
    })->name('pengumuman.show');

    // Landing Page Admin Routes
    Route::get('/landing-page', function () {
        return view('landing-page-livewire');
    })->name('landing-page.index');
    Route::get('/landing-page/create', function () {
        return view('landing-page-create');
    })->name('landing-page.create');
    Route::get('/landing-page/{landingPage}/edit', function ($landingPage) {
        $landingPage = \App\Models\LandingPage::findOrFail($landingPage);
        return view('landing-page-edit', compact('landingPage'));
    })->name('landing-page.edit');
    Route::get('/landing-page/{landingPage}', function ($landingPage) {
        $landingPage = \App\Models\LandingPage::findOrFail($landingPage);
        return view('landing-page-show', compact('landingPage'));
    })->name('landing-page.show');

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

    // Admin User Management Routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::resource('users', UserManagementController::class);
    });
});

// Image routes for web interface (no authentication required)
Route::prefix('images')->name('web.image.')->group(function () {
    Route::get('/business/{filename}', [ImageController::class, 'businessImage'])->name('business');
    Route::get('/gallery/{filename}', [ImageController::class, 'galleryImage'])->name('gallery');
    Route::get('/serve/{path}', [ImageController::class, 'serveImage'])->name('serve');
});

// TinyMCE Image Upload Route
Route::post('/admin/upload-image', function (Request $request) {
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/uploads/tinymce', $filename);

        return response()->json([
            'location' => asset('storage/uploads/tinymce/' . $filename)
        ]);
    }

    return response()->json(['error' => 'No file uploaded'], 400);
})->middleware('auth')->name('tinymce.upload');

// Public Landing Page Routes (no authentication required)
Route::get('/page/{slug}', function ($slug) {
    $landingPage = \App\Models\LandingPage::where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();

    return view('landing-page-public', compact('landingPage'));
})->name('landing-page.public.show');

// API routes
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/user', function () {
        return auth()->user();
    });
});
