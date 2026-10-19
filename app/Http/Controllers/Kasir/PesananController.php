<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Dashboard Kasir dengan data ringkasan real-time.
     */
    public function dashboard()
    {
        $menungguVerifikasi = Transaksi::where('status', 'menunggu_verifikasi')->count();
        $sedangDiproses = Transaksi::where('status', 'diproses')->count();
        $selesaiHariIni = Transaksi::where('status', 'selesai')
            ->whereDate('tanggal_transaksi', today())
            ->count();

        return view('kasir.dashboard', compact(
            'menungguVerifikasi',
            'sedangDiproses',
            'selesaiHariIni'
        ));
    }

    /**
     * Daftar Pesanan Masuk (Real-time dari Database).
     */
    public function index(Request $request)
    {
        $pesanan = Transaksi::with(['pelanggan', 'kasir', 'detailTransaksis.produk'])
            ->orderByRaw("CASE 
                WHEN status = 'menunggu_verifikasi' THEN 1 
                WHEN status = 'diproses' THEN 2 
                WHEN status = 'dikirim' THEN 3 
                WHEN status = 'selesai' THEN 4 
                ELSE 5 END")
            ->orderByDesc('created_at')
            ->get();

        $counts = [
            'semua' => $pesanan->count(),
            'menunggu_verifikasi' => $pesanan->where('status', 'menunggu_verifikasi')->count(),
            'diproses' => $pesanan->where('status', 'diproses')->count(),
            'dikirim' => $pesanan->where('status', 'dikirim')->count(),
            'selesai' => $pesanan->where('status', 'selesai')->count(),
            'ditolak' => $pesanan->where('status', 'ditolak')->count(),
        ];

        return view('kasir.pesanan', compact('pesanan', 'counts'));
    }

    /**
     * Detail Pesanan Masuk.
     */
    public function show($id)
    {
        $pesanan = Transaksi::with(['pelanggan', 'kasir', 'detailTransaksis.produk'])
            ->where('id', $id)
            ->orWhere('kode_transaksi', $id)
            ->firstOrFail();

        return view('kasir.detail-pesanan', compact('pesanan'));
    }

    /**
     * Verifikasi Cepat Pesanan (Status berubah menjadi Diproses).
     */
    public function verifikasi(Request $request, $id)
    {
        $pesanan = Transaksi::where('id', $id)->orWhere('kode_transaksi', $id)->firstOrFail();

        $pesanan->status = 'diproses';
        if (Auth::check()) {
            $pesanan->kasir_id = Auth::id();
        }
        $pesanan->save();

        return redirect()->back()->with('success', 'Pesanan '.($pesanan->kode_transaksi ?? ('#'.$pesanan->id)).' berhasil diverifikasi dan statusnya berubah menjadi Diproses.');
    }

    /**
     * Tolak Bukti Transfer / Pesanan.
     */
    public function tolak(Request $request, $id)
    {
        $pesanan = Transaksi::where('id', $id)->orWhere('kode_transaksi', $id)->firstOrFail();

        $pesanan->status = 'ditolak';
        if (Auth::check()) {
            $pesanan->kasir_id = Auth::id();
        }
        $pesanan->save();

        return redirect()->back()->with('info', 'Bukti pembayaran pesanan '.($pesanan->kode_transaksi ?? ('#'.$pesanan->id)).' telah ditolak.');
    }

    /**
     * Update Status Pesanan (diproses, dikirim, selesai, ditolak).
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu_verifikasi,diproses,dikirim,selesai,ditolak',
        ]);

        $pesanan = Transaksi::where('id', $id)->orWhere('kode_transaksi', $id)->firstOrFail();

        $pesanan->status = $validated['status'];
        if (Auth::check()) {
            $pesanan->kasir_id = Auth::id();
        }

        // Jika selesai dan bayar masih 0, set nominal bayar = total harga
        if ($validated['status'] === 'selesai' && $pesanan->nominal_bayar <= 0) {
            $pesanan->nominal_bayar = $pesanan->total_harga;
            $pesanan->kembalian = 0;
        }

        $pesanan->save();

        $labelStatus = ucfirst(str_replace('_', ' ', $pesanan->status));

        return redirect()->back()->with('success', "Status pesanan {$pesanan->kode_transaksi} berhasil diperbarui menjadi: {$labelStatus}.");
    }
}
