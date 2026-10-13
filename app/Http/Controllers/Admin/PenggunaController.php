<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenggunaRequest;
use App\Models\User;

class PenggunaController extends Controller
{
    /**
     * Tampilkan daftar pengguna.
     */
    public function index()
    {
        $pengguna = User::orderBy('created_at', 'desc')->get();
        return view('admin.pengguna.index', compact('pengguna'));
    }

    /**
     * Simpan pengguna baru.
     */
    public function store(PenggunaRequest $request)
    {
        User::create([
            'nama'     => $request->nama,
            'username' => $request->username,
            'password' => $request->password,   // auto-hash via cast
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Update pengguna.
     */
    public function update(PenggunaRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->nama     = $request->nama;
        $user->username = $request->username;
        $user->role     = $request->role;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    /**
     * Hapus pengguna.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}