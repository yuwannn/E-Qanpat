<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\RiwayatController;

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.action');
});

// Route untuk Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // --- ROUTE CRUD KATEGORI ---
    Route::resource('admin/kategori', KategoriController::class);
    // --- Route CRUD Menu
    Route::resource('admin/menu', MenuController::class);
    // --- Route CRUD Meja
    Route::resource('admin/meja', MejaController::class);
    // Dashboard Cashier
    Route::get('/cashier/dashboard', [KasirController::class, 'index'])->name('cashier.dashboard');
    Route::post('/cashier/order/{id}/update', [KasirController::class, 'updateStatus'])->name('cashier.update');
    // Cetak Struk
    Route::get('/cashier/order/{id}/print', [KasirController::class, 'printStruk'])->name('cashier.print');
    // Route Riwayat Transaksi
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');
});

// --- ROUTE PELANGGAN (PUBLIC) ---
Route::get('/order/{nomor_meja}', [OrderController::class, 'index'])->name('order.index');

// TAMBAHAN BARU:
Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/view', [OrderController::class, 'showCart'])->name('cart.show');
Route::post('/cart/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');
Route::get('/order/success/{id}', [OrderController::class, 'success'])->name('order.success');

Route::get('/', function () {
    return view('welcome');
});