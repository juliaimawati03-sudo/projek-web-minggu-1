<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatatanKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelianController extends Controller
{
    public function create()
    {
        return view('admin.pembelian.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'tanggal'       => 'required|date',
            'nominal'       => 'required|numeric|min:1',
            'keterangan'    => 'required|string|max:500',
        ]);

        CatatanKeuangan::create([
            'user_id'    => Auth::id(),
            'tanggal'    => $validated['tanggal'],
            'nominal'    => -abs($validated['nominal']),
            'keterangan' => 'Pembelian dari ' . $validated['nama_supplier'] . ' — ' . $validated['keterangan'],
        ]);

        return redirect()->route('admin.pembelian.create')
            ->with('success', 'Pembelian berhasil dicatat sebagai pengeluaran.');
    }
}