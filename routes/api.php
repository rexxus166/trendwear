<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentCallbackController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\Api\CheckoutController;
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

    // ROUTE CART (API)
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);

    // Isian baru untuk Mobile
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // ROUTE WISHLIST (API)
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);

    // ROUTE CHECKOUT (API)
    Route::post('/checkout', [CheckoutController::class, 'checkout']);

    // ROUTE ADDRESS (API)
    Route::get('/address/primary', [AddressController::class, 'getPrimaryAddress']);
    Route::post('/address', [AddressController::class, 'store']);

    // ROUTE SHIPPING (API)
    Route::post('/shipping/check', [ShippingController::class, 'checkCost']);

    // Logout (Hapus Token)
    Route::post('/logout', [AuthController::class, 'logout']);
});
