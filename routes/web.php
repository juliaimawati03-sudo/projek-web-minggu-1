<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CatatanKeuanganController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\PembelianController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\Admin\PasswordRequestController;

// =====================================================
// PUBLIC
// =====================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// =====================================================
// ORDER / CHECKOUT
// =====================================================
Route::get('/checkout', function () {
    return view('orders.form');
})->name('checkout');

Route::get('/orders/payment', function () {
    return view('orders.payment');
})->name('orders.payment');

Route::get('/orders/success', function () {
    return view('orders.success');
})->name('orders.success');

// =====================================================
// AUTH
// =====================================================
Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',  [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Password (frontend only)
Route::get('/forgot-password',       [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password',      [ForgotPasswordController::class, 'submit'])  ->name('password.submit');
Route::get('/forgot-password/sent',  [ForgotPasswordController::class, 'sent'])    ->name('password.sent');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

Route::get('/password-changed', function () {
    return view('auth.password-changed');
})->name('password.changed');

// =====================================================
// ADMIN PANEL
// =====================================================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {


    // ===== PERMINTAAN RESET PASSWORD =====
    Route::get('/password-request',             [PasswordRequestController::class, 'index']) ->name('password-request.index');
    Route::put('/password-request/{id}/reset',  [PasswordRequestController::class, 'reset']) ->name('password-request.reset');
    Route::put('/password-request/{id}/reject', [PasswordRequestController::class, 'reject'])->name('password-request.reject');

    // ===== DASHBOARD =====
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // ===== TRANSAKSI =====
    Route::get('/transaksi', function () {
        return view('admin.transaksi.index');
    })->name('transaksi.index');

    Route::get('/transaksi/{id}', function ($id) {
        return view('admin.transaksi.show');
    })->name('transaksi.show');

// ===== PEMBELIAN — PAKAI CONTROLLER =====
    Route::get('/pembelian',  [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian', [PembelianController::class, 'store']) ->name('pembelian.store');

    // ===== PRODUK =====
    Route::get('/produk',          [ProdukController::class, 'index'])  ->name('produk.index');
    Route::post('/produk',         [ProdukController::class, 'store'])  ->name('produk.store');
    Route::put('/produk/{id}',     [ProdukController::class, 'update']) ->name('produk.update');
    Route::delete('/produk/{id}',  [ProdukController::class, 'destroy'])->name('produk.destroy');
    // ===== SUPPLIER — PAKAI CONTROLLER =====
    Route::get('/supplier',           [SupplierController::class, 'index'])  ->name('supplier.index');
    Route::post('/supplier',          [SupplierController::class, 'store'])  ->name('supplier.store');
    Route::put('/supplier/{id}',      [SupplierController::class, 'update']) ->name('supplier.update');
    Route::delete('/supplier/{id}',   [SupplierController::class, 'destroy'])->name('supplier.destroy');

    // ===== PENGGUNA — PAKAI CONTROLLER =====
    Route::get('/pengguna',           [PenggunaController::class, 'index'])  ->name('pengguna.index');
    Route::post('/pengguna',          [PenggunaController::class, 'store'])  ->name('pengguna.store');
    Route::put('/pengguna/{id}',      [PenggunaController::class, 'update']) ->name('pengguna.update');
    Route::delete('/pengguna/{id}',   [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    // ===== LAPORAN KEUANGAN — PAKAI CONTROLLER =====
    Route::get('/laporan',              [CatatanKeuanganController::class, 'index'])    ->name('laporan.index');
    Route::post('/laporan',             [CatatanKeuanganController::class, 'store'])    ->name('laporan.store');
    Route::put('/laporan/{id}',         [CatatanKeuanganController::class, 'update'])   ->name('laporan.update');
    Route::delete('/laporan/{id}',      [CatatanKeuanganController::class, 'destroy'])  ->name('laporan.destroy');
    Route::get('/laporan/export/pdf',   [CatatanKeuanganController::class, 'exportPdf'])->name('laporan.pdf');
    });

// =====================================================
// KASIR PANEL
// =====================================================
Route::prefix('kasir')->middleware(['auth', 'role:kasir'])->name('kasir.')->group(function () {

    Route::get('/dashboard', function () {
        return view('kasir.dashboard');
    })->name('dashboard');

    Route::get('/pesanan', function () {
        return view('kasir.pesanan');
    })->name('pesanan.index');

    Route::get('/pesanan/{id}', function ($id) {
        return view('kasir.detail-pesanan');
    })->name('pesanan.show');

    Route::get('/riwayat', [\App\Http\Controllers\Kasir\RiwayatController::class, 'index'])
    ->name('riwayat.index');
});