<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CatatanKeuanganRequest;
use App\Models\CatatanKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanKeuanganController extends Controller
{
    /**
     * Tampilkan buku kas.
     */
    public function index(Request $request)
    {
        $dari   = $request->input('dari', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->input('sampai', now()->format('Y-m-d'));

        $catatan = CatatanKeuangan::with('user')
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $totalDebit  = $catatan->where('nominal', '>', 0)->sum('nominal');
        $totalKredit = abs($catatan->where('nominal', '<', 0)->sum('nominal'));

        return view('admin.laporan.index', compact(
            'catatan', 'totalDebit', 'totalKredit', 'dari', 'sampai'
        ));
    }

    /**
     * Simpan catatan keuangan baru.
     */
    public function store(CatatanKeuanganRequest $request)
    {
        CatatanKeuangan::create([
            'user_id'    => Auth::id(),
            'tanggal'    => $request->tanggal,
            'nominal'    => $request->nominal,   // bisa positif atau negatif
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Catatan keuangan berhasil disimpan.');
    }

    /**
     * Hapus catatan keuangan.
     */
    public function destroy($id)
    {
        $catatan = CatatanKeuangan::findOrFail($id);
        $catatan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Catatan keuangan berhasil dihapus.');
    }
}