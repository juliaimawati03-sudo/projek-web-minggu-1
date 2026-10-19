<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatatanKeuangan;
use App\Models\PasswordRequest;
use App\Models\Produk;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman utama Dashboard Admin dengan statistik real-time.
     */
    public function index()
    {
        $totalTransaksiHariIni = Transaksi::whereDate('tanggal_transaksi', today())->count();
        $pemasukanHariIni = Transaksi::where('status', 'selesai')
            ->whereDate('tanggal_transaksi', today())
            ->sum('total_harga');

        $pengeluaranHariIni = abs(CatatanKeuangan::where('nominal', '<', 0)
            ->whereDate('tanggal', today())
            ->sum('nominal'));

        $produkStokMenipis = Produk::where('stok', '<', 10)->count();

        $transaksiTerbaru = Transaksi::with(['kasir', 'pelanggan'])
            ->orderByDesc('tanggal_transaksi')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        $pendingPasswordRequests = PasswordRequest::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalTransaksiHariIni',
            'pemasukanHariIni',
            'pengeluaranHariIni',
            'produkStokMenipis',
            'transaksiTerbaru',
            'pendingPasswordRequests'
        ));
    }
}
