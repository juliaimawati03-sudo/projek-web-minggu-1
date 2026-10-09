<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Tampilkan daftar supplier.
     */
    public function index()
    {
        $supplier = Supplier::orderBy('created_at', 'desc')->get();
        return view('admin.supplier.index', compact('supplier'));
    }

    /**
     * Simpan supplier baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255|unique:supplier,nama_supplier',
            'no_telepon'    => 'required|string|max:20',
            'alamat'        => 'required|string',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.unique'   => 'Nama supplier sudah terdaftar.',
            'nama_supplier.max'      => 'Nama supplier maksimal 255 karakter.',
            'no_telepon.required'    => 'Nomor telepon wajib diisi.',
            'no_telepon.max'         => 'Nomor telepon maksimal 20 karakter.',
            'alamat.required'        => 'Alamat wajib diisi.',
        ]);

        Supplier::create($validated);

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Update supplier.
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'nama_supplier' => 'required|string|max:255|unique:supplier,nama_supplier,' . $id,
            'no_telepon'    => 'required|string|max:20',
            'alamat'        => 'required|string',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.unique'   => 'Nama supplier sudah terdaftar.',
            'nama_supplier.max'      => 'Nama supplier maksimal 255 karakter.',
            'no_telepon.required'    => 'Nomor telepon wajib diisi.',
            'no_telepon.max'         => 'Nomor telepon maksimal 20 karakter.',
            'alamat.required'        => 'Alamat wajib diisi.',
        ]);

        $supplier->update($validated);

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Hapus supplier.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}