<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Tampilkan seluruh data transaksi penjualan.
     */
    public function index(Request $request)
    {
        $dari = $request->input('dari');
        $sampai = $request->input('sampai');
        $status = $request->input('status');

        $query = Transaksi::with(['kasir', 'pelanggan', 'detailTransaksis.produk'])
            ->when($dari, fn ($q) => $q->whereDate('tanggal_transaksi', '>=', $dari))
            ->when($sampai, fn ($q) => $q->whereDate('tanggal_transaksi', '<=', $sampai))
            ->when($status, fn ($q) => $q->where('status', $status));

        $totalPendapatan = (clone $query)->where('status', 'selesai')->sum('total_harga');
        $totalTransaksi = (clone $query)->count();

        $transaksi = $query->orderByDesc('tanggal_transaksi')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.transaksi.index', compact('transaksi', 'totalPendapatan', 'totalTransaksi', 'dari', 'sampai', 'status'));
    }

    /**
     * Tampilkan detail transaksi.
     */
    public function show($id)
    {
        $transaksi = Transaksi::with(['kasir', 'pelanggan', 'detailTransaksis.produk'])
            ->where('id', $id)
            ->orWhere('kode_transaksi', $id)
            ->firstOrFail();

        return view('admin.transaksi.show', compact('transaksi'));
    }
}
