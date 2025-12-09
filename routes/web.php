<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- RUTE UNTUK USER BIASA (MEMBER) ---
Route::get('/dashboard', function () {
    return view('page.dashboard.index');
})->middleware(['auth', 'verified', 'role:user'])->name('dashboard');


// --- RUTE UNTUK ADMIN ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('page.admin.dashboard.index');
    })->name('admin.dashboard');

    // --- MODULE PRODUCTS ---
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    //Route Delete Product
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    //Route untuk hapus gambar spesifik
    Route::delete('/product-images/{id}', [ProductController::class, 'destroyImage'])->name('admin.products.delete-image');

    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');

    // --- MODULE ORDERS ---
    Route::get('/orders', function () {
        return view('page.admin.pesanan.index');
    })->name('admin.orders');

    // --- MODULE CUSTOMERS ---
    Route::get('/customers', function () {
        return view('page.admin.pelanggan.index');
    })->name('admin.customers');

    // --- MODULE ANALYTICS ---
    Route::get('/analytics', function () {
        return view('page.admin.analisis.index');
    })->name('admin.analytics');

    // --- MODULE SETTINGS ---
    Route::get('/settings', function () {
        return view('page.admin.pengaturan.index');
    })->name('admin.pengaturan');
});


// Route bawaan Breeze untuk profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
