<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
// Controller Admin
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::post('/ai-chat', [App\Http\Controllers\AiChatController::class, 'chat'])->name('ai.chat');

// ==========================================
// RUTE UNTUK USER BIASA (MEMBER)
// ==========================================
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {

    // --- Dashboard & Shop Pages ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [DashboardController::class, 'search'])->name('search');
    Route::get('/search-mobile', function () {
        return view('page.search.index');
    })->name('search.mobile');

    // Halaman Shop (Semua Produk)
    Route::get('/product/all', [DashboardController::class, 'shop'])->name('shop');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Halaman Kategori Spesifik
    Route::get('/category/{slug}', [DashboardController::class, 'category'])->name('category.show');

    // Halaman Trending
    Route::get('/trending', [DashboardController::class, 'trending'])->name('trending');



    // --- Shopping Cart ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');       // Tambah item
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update'); // Update qty
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy'); // Hapus item

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/orders', [UserOrderController::class, 'index'])->name('pesanan');
    Route::get('/profile/orders/{order_number}', [UserOrderController::class, 'show'])->name('orders.show');

    // MODULE ADDRESS
    Route::get('/profile/address', [AddressController::class, 'index'])->name('address.index');
    Route::post('/profile/address', [AddressController::class, 'store'])->name('address.store');
    Route::put('/profile/address/{id}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/profile/address/{id}', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::post('/profile/address/{id}/set-primary', [AddressController::class, 'setPrimary'])->name('address.setPrimary');

    // Detail Produk (Moved to bottom to avoid conflict with other routes)
    Route::get('/{slug}', [DashboardController::class, 'show'])->name('product.detail');
});


// ==========================================
// RUTE UNTUK ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // --- Dashboard ---
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

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
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');

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
