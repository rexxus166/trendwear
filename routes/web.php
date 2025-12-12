<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AddressController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// ==========================================
// RUTE UNTUK USER BIASA (MEMBER)
// ==========================================
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {

    // --- Dashboard & Shop Pages ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman Shop (Semua Produk)
    Route::get('/product/all', [DashboardController::class, 'shop'])->name('shop');

    // Halaman Kategori Spesifik
    Route::get('/category/{slug}', [DashboardController::class, 'category'])->name('category.show');

    // Halaman Trending
    Route::get('/trending', [DashboardController::class, 'trending'])->name('trending');

    // Detail Produk
    Route::get('/product/{slug}', [DashboardController::class, 'show'])->name('product.detail');

    // --- Shopping Cart ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');       // Tambah item
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update'); // Update qty
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy'); // Hapus item

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // MODULE ADDRESS
    Route::get('/profile/address', [AddressController::class, 'index'])->name('address.index');
    Route::post('/profile/address', [AddressController::class, 'store'])->name('address.store');
    Route::put('/profile/address/{id}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/profile/address/{id}', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::post('/profile/address/{id}/set-primary', [AddressController::class, 'setPrimary'])->name('address.setPrimary');
});


// ==========================================
// RUTE UNTUK ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // --- Dashboard ---
    Route::get('/dashboard', function () {
        return view('page.admin.dashboard.index');
    })->name('admin.dashboard');

    // --- Module Products (CRUD) ---
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Hapus Gambar Spesifik via AJAX
    Route::delete('/product-images/{id}', [ProductController::class, 'destroyImage'])->name('admin.products.delete-image');

    // --- Module Categories ---
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');

    // --- Module Orders ---
    Route::get('/orders', function () {
        return view('page.admin.pesanan.index');
    })->name('admin.orders');

    // --- Module Customers ---
    Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers');
    Route::post('/customers', [CustomerController::class, 'store'])->name('admin.customers.store'); // BARU
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('admin.customers.update'); // BARU
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');

    // --- Module Analytics ---
    Route::get('/analytics', function () {
        return view('page.admin.analisis.index');
    })->name('admin.analytics');

    // --- Module Settings ---
    Route::get('/settings', function () {
        return view('page.admin.pengaturan.index');
    })->name('admin.pengaturan');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Shipping Routes
Route::prefix('shipping')->group(function () {
    Route::get('/provinces', [ShippingController::class, 'getProvince']);
    Route::get('/cities', [ShippingController::class, 'getCity']);
    Route::get('/districts', [ShippingController::class, 'getDistrict']);
    Route::post('/check-cost', [ShippingController::class, 'checkCost'])->name('shipping.check');
    Route::get('/services', [ShippingController::class, 'getServices']);
});

Route::get('/cari-lokasi-toko/{kecamatan}', function ($kecamatan) {
    $apiKey = env('RAJAONGKIR_API_KEY');
    $baseUrl = 'https://rajaongkir.komerce.id/api/v1';

    $response = Http::withoutVerifying()->withHeaders([
        'key' => $apiKey
    ])->get("{$baseUrl}/destination/domestic-destination", [
        'search' => $kecamatan,
        'limit' => 5
    ]);

    return $response->json();
});

require __DIR__ . '/auth.php';
