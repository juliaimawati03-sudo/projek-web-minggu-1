<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatatanKeuangan;
use App\Models\Pengeluaran;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PembelianController extends Controller
{
    /**
     * Tampilkan form pembelian ke supplier beserta daftar supplier dan riwayat.
     */
    public function create(): View
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        $riwayatPembelian = Pengeluaran::with('supplier')
            ->latest('tanggal')
            ->take(15)
            ->get();

        return view('admin.pembelian.create', compact('suppliers', 'riwayatPembelian'));
    }

    /**
     * Simpan pembelian supplier ke database (tabel pengeluaran & catatan_keuangan).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'nullable|exists:supplier,id',
            'nama_supplier' => 'required_without:supplier_id|nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:500',
        ]);

        // Cari atau buat supplier
        if (! empty($validated['supplier_id'])) {
            $supplier = Supplier::findOrFail($validated['supplier_id']);
        } else {
            $supplier = Supplier::create([
                'nama_supplier' => $validated['nama_supplier'],
                'no_telepon' => $validated['no_telepon'] ?? '-',
                'alamat' => $validated['alamat'] ?? '-',
            ]);
        }

        // Simpan ke tabel pengeluaran
        Pengeluaran::create([
            'supplier_id' => $supplier->id,
            'tanggal' => $validated['tanggal'],
            'nominal' => (int) $validated['nominal'],
            'keterangan' => $validated['keterangan'],
        ]);

        // Simpan ke catatan keuangan
        CatatanKeuangan::create([
            'user_id' => Auth::id(),
            'tanggal' => $validated['tanggal'],
            'nominal' => -abs((int) $validated['nominal']),
            'keterangan' => 'Pembelian dari '.$supplier->nama_supplier.' — '.$validated['keterangan'],
        ]);

        return redirect()->route('admin.pembelian.create')
            ->with('success', 'Pembelian dari "'.$supplier->nama_supplier.'" berhasil dicatat ke pengeluaran dan laporan keuangan!');
    }
}
