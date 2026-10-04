<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PenggunaController;

// =====================================================
// PUBLIC
// =====================================================
Route::get('/', function () {
    return view('home');
})->name('home');

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
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/forgot-password/sent', function () {
    return view('auth.email-sent');
})->name('password.sent');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

Route::get('/password-changed', function () {
    return view('auth.password-changed');
})->name('password.changed');

// =====================================================
// ADMIN PANEL
// =====================================================
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/transaksi', function () {
        return view('admin.transaksi.index');
    })->name('transaksi.index');

    Route::get('/transaksi/{id}', function ($id) {
        return view('admin.transaksi.show');
    })->name('transaksi.show');

    Route::get('/pembelian', function () {
        return view('admin.pembelian.create');
    })->name('pembelian.create');

    Route::post('/pembelian', function () {
        // Backend nanti
    })->name('pembelian.store');

    Route::get('/produk', function () {
        return view('admin.produk.index');
    })->name('produk.index');

    Route::post('/produk', function () {
        // Backend nanti
    })->name('produk.store');

    Route::get('/supplier', function () {
        return view('admin.supplier.index');
    })->name('supplier.index');

    Route::post('/supplier', function () {
        // Backend nanti
    })->name('supplier.store');

    // ===== PENGGUNA — PAKAI CONTROLLER =====
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
    Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/laporan', function () {
        return view('admin.laporan.index');
    })->name('laporan.index');
});

// =====================================================
// KASIR PANEL
// =====================================================
Route::prefix('kasir')->name('kasir.')->group(function () {

    Route::get('/dashboard', function () {
        return view('kasir.dashboard');
    })->name('dashboard');

    Route::get('/pesanan', function () {
        return view('kasir.pesanan');
    })->name('pesanan.index');

    Route::get('/pesanan/{id}', function ($id) {
        return view('kasir.detail-pesanan');
    })->name('pesanan.show');

    Route::get('/riwayat', function () {
        return view('kasir.riwayat');
    })->name('riwayat.index');
});