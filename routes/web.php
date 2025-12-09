<?php

use App\Http\Controllers\ProfileController;
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

    Route::get('/dashboard', function () {
        return view('page.admin.dashboard.index');
    })->name('admin.dashboard');

    // Route Produk
    Route::get('/products', function () {
        return view('page.admin.produk.index');
    })->name('admin.products');

    // Route Pesanan
    Route::get('/orders', function () {
        return view('page.admin.pesanan.index');
    })->name('admin.orders');

    // Route Pelanggan
    Route::get('/customers', function () {
        return view('page.admin.pelanggan.index');
    })->name('admin.customers');

    // Route Analisis
    Route::get('/analytics', function () {
        return view('page.admin.analisis.index');
    })->name('admin.analytics');

    // Route Pengaturan
    Route::get('/pengaturan', function () {
        return view('page.admin.pengaturan.index');
    })->name('admin.pengaturan');

    // Tambahkan route admin lainnya di sini...
});


// Route bawaan Breeze untuk profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
