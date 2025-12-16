<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentCallbackController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ==========================
// PUBLIC ROUTES (Tanpa Login)
// ==========================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);

// Callback Midtrans (Biarkan Public)
Route::post('midtrans-callback', [PaymentCallbackController::class, 'receive']);


// ==========================
// PROTECTED ROUTES (Harus Login / Bawa Token)
// ==========================
Route::middleware('auth:sanctum')->group(function () {

    // Ambil data user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout (Hapus Token)
    Route::post('/logout', [AuthController::class, 'logout']);
});
