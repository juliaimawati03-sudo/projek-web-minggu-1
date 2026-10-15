<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRiwayatRequest;
use App\Models\Transaksi;

class RiwayatController extends Controller
{
    public function index(FilterRiwayatRequest $request)
    {
        $dari   = $request->input('dari');
        $sampai = $request->input('sampai');

        $query = Transaksi::with('kasir')
            ->when($dari, fn ($q) => $q->whereDate('tanggal_transaksi', '>=', $dari))
            ->when($sampai, fn ($q) => $q->whereDate('tanggal_transaksi', '<=', $sampai));

        $jumlahTransaksi = (clone $query)->count();
        $totalPendapatan = (clone $query)->sum('total_harga');

        $transaksi = $query->orderByDesc('tanggal_transaksi')
            ->paginate(10)
            ->withQueryString();

        return view('kasir.riwayat', compact(
            'transaksi', 'dari', 'sampai', 'jumlahTransaksi', 'totalPendapatan'
        ));
    }
}