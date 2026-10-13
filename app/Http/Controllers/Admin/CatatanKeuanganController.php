<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatatanKeuangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanKeuanganController extends Controller
{
    /**
     * Tampilkan buku kas + filter periode.
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
     * Simpan catatan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'nominal'    => 'required|numeric|not_in:0',
            'keterangan' => 'required|string|max:500',
        ]);

        CatatanKeuangan::create([
            'user_id'    => Auth::id(),
            'tanggal'    => $validated['tanggal'],
            'nominal'    => $validated['nominal'],
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Catatan keuangan berhasil disimpan.');
    }

    /**
     * Update catatan.
     */
    public function update(Request $request, $id)
    {
        $catatan = CatatanKeuangan::findOrFail($id);

        $validated = $request->validate([
            'tanggal'    => 'required|date',
            'nominal'    => 'required|numeric|not_in:0',
            'keterangan' => 'required|string|max:500',
        ]);

        $catatan->update($validated);

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Catatan keuangan berhasil diperbarui.');
    }

    /**
     * Hapus catatan.
     */
    public function destroy($id)
    {
        $catatan = CatatanKeuangan::findOrFail($id);
        $catatan->delete();

        return redirect()->route('admin.laporan.index')
            ->with('success', 'Catatan keuangan berhasil dihapus.');
    }

    /**
     * Export laporan ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $dari   = $request->input('dari', now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->input('sampai', now()->format('Y-m-d'));

        $catatan = CatatanKeuangan::with('user')
            ->whereBetween('tanggal', [$dari, $sampai])
            ->orderBy('tanggal', 'asc')
            ->get();

        $totalDebit  = $catatan->where('nominal', '>', 0)->sum('nominal');
        $totalKredit = abs($catatan->where('nominal', '<', 0)->sum('nominal'));

        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'catatan', 'totalDebit', 'totalKredit', 'dari', 'sampai'
        ));

        return $pdf->download('laporan-keuangan-' . $dari . '-sd-' . $sampai . '.pdf');
    }
}