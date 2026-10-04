<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    // Tampilkan daftar pengguna
    public function index()
    {
        $pengguna = User::orderBy('created_at', 'desc')->get();
        return view('admin.pengguna.index', compact('pengguna'));
    }

    // Simpan pengguna baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,kasir',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Role wajib dipilih.',
        ]);

        User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'password' => $validated['password'], // cast auto-hash
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Update pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('user')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,kasir',
        ]);

        $user->nama = $validated['nama'];
        $user->username = $validated['username'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = $validated['password']; // cast auto-hash
        }

        $user->save();

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    // Hapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}