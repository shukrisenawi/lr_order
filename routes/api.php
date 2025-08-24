<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProspekApiController;
use App\Http\Controllers\Api\ApiTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API routes (with API key authentication)
Route::middleware(['api.auth'])->group(function () {

    // Prospect API endpoints
    Route::prefix('prospects')->group(function () {
        Route::get('/', [ProspekApiController::class, 'index']);
        Route::get('/search', [ProspekApiController::class, 'search']);
        Route::get('/{no_tel}', [ProspekApiController::class, 'show']);
        Route::get('/{no_tel}/addresses', [ProspekApiController::class, 'addresses']);
        Route::get('/{no_tel}/purchases', [ProspekApiController::class, 'purchases']);
    });

    // API Info endpoint
    Route::get('/info', function () {
        return response()->json([
            'api_name' => 'Business Management API',
            'version' => '1.0.0',
            'description' => 'API untuk mengakses maklumat prospek, alamat, dan pembelian',
            'endpoints' => [
                'GET /api/prospects' => 'Senarai semua prospek',
                'GET /api/prospects/search?no_tel={phone}' => 'Cari prospek berdasarkan no telefon',
                'GET /api/prospects/{no_tel}' => 'Detail lengkap prospek berdasarkan no telefon',
                'GET /api/prospects/{no_tel}/addresses' => 'Alamat prospek',
                'GET /api/prospects/{no_tel}/purchases' => 'Pembelian prospek'
            ],
            'authentication' => 'API Key required in header: X-API-Key'
        ]);
    });
});

// Protected routes for token management (requires web authentication)
Route::middleware(['auth:web'])->group(function () {
    Route::prefix('tokens')->group(function () {
        Route::get('/', [ApiTokenController::class, 'index']);
        Route::post('/', [ApiTokenController::class, 'store']);
        Route::delete('/{token}', [ApiTokenController::class, 'destroy']);
    });
});
