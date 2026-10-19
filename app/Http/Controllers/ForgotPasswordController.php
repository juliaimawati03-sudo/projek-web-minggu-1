<?php

namespace App\Http\Controllers;

use App\Models\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form lupa password.
     */
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Simpan permintaan reset password ke database.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'nama' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'pesan' => 'nullable|string|max:500',
        ], [
            'username.required' => 'Username wajib diisi.',
        ]);

        // Cek apakah username terdaftar
        $user = User::where('username', $validated['username'])->first();

        if (! $user) {
            return back()
                ->withInput()
                ->withErrors(['username' => 'Username tidak terdaftar. Hubungi admin untuk bantuan.']);
        }

        // Cek apakah sudah ada permintaan pending
        $existing = PasswordRequest::where('username', $validated['username'])
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->route('password.sent')
                ->with('info', 'Permintaan Anda sudah dikirim sebelumnya. Mohon tunggu admin.');
        }

        // Simpan permintaan
        PasswordRequest::create($validated);

        return redirect()->route('password.sent')
            ->with('success', 'Permintaan reset password berhasil dikirim ke admin.');
    }

    /**
     * Halaman konfirmasi terkirim.
     */
    public function sent()
    {
        return view('auth.email-sent');
    }
}
