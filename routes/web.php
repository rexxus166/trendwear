<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;
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
    Route::get('/customers', function () {
        return view('page.admin.pelanggan.index');
    })->name('admin.customers');

    // --- Module Analytics ---
    Route::get('/analytics', function () {
        return view('page.admin.analisis.index');
    })->name('admin.analytics');

    // --- Module Settings ---
    Route::get('/settings', function () {
        return view('page.admin.pengaturan.index');
    })->name('admin.pengaturan');
});


// ==========================================
// PROFIL USER (Breeze Default)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
