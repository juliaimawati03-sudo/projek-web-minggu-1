<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CatatanKeuanganController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PasswordRequestController;
use App\Http\Controllers\Admin\PembelianController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kasir\PesananController;
use App\Http\Controllers\Kasir\RiwayatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VarianController;

// =====================================================
// PUBLIC
// =====================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// =====================================================
// ORDER / CHECKOUT
// =====================================================
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/orders/payment', [OrderController::class, 'payment'])->name('orders.payment');
Route::post('/orders/submit', [OrderController::class, 'submitOrder'])->name('orders.submit');
Route::get('/orders/success', [OrderController::class, 'success'])->name('orders.success');
Route::get('/pesanan-saya', [OrderController::class, 'myOrders'])->name('orders.my-orders');

// =====================================================
// AUTH
// =====================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Password (frontend only)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'submit'])->name('password.submit');
Route::get('/forgot-password/sent', [ForgotPasswordController::class, 'sent'])->name('password.sent');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

Route::get('/password-changed', function () {
    return view('auth.password-changed');
})->name('password.changed');

// =====================================================
// ADMIN PANEL (Hanya Admin yang Login)
// =====================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // ===== PERMINTAAN RESET PASSWORD =====
    Route::get('/password-request', [PasswordRequestController::class, 'index'])->name('password-request.index');
    Route::put('/password-request/{id}/reset', [PasswordRequestController::class, 'reset'])->name('password-request.reset');
    Route::put('/password-request/{id}/reject', [PasswordRequestController::class, 'reject'])->name('password-request.reject');

    // ===== DASHBOARD =====
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== TRANSAKSI =====
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');

    // ===== PEMBELIAN =====
    Route::get('/pembelian', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian', [PembelianController::class, 'store'])->name('pembelian.store');

    // ===== PRODUK =====
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // ===== SUPPLIER =====
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

    // ===== PENGGUNA =====
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    // ===== LAPORAN KEUANGAN =====
    Route::get('/laporan', [CatatanKeuanganController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [CatatanKeuanganController::class, 'store'])->name('laporan.store');
    Route::put('/laporan/{id}', [CatatanKeuanganController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [CatatanKeuanganController::class, 'destroy'])->name('laporan.destroy');
    Route::get('/laporan/export/pdf', [CatatanKeuanganController::class, 'exportPdf'])->name('laporan.pdf');
});

// =====================================================
// KASIR PANEL (Hanya Kasir & Admin yang Login)
// =====================================================
Route::middleware(['auth', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [PesananController::class, 'dashboard'])->name('dashboard');
    
    // ===== PESANAN =====
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{id}/verifikasi', [PesananController::class, 'verifikasi'])->name('pesanan.verifikasi');
    Route::post('/pesanan/{id}/tolak', [PesananController::class, 'tolak'])->name('pesanan.tolak');
    Route::put('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])->name('pesanan.status');
    
    // ===== RIWAYAT =====
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

  
});