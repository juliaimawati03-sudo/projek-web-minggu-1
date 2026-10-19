<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     * Kalau sudah login, redirect ke dashboard sesuai role.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Tampilkan form registrasi pelanggan.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun pelanggan baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:user,username'],
            'no_hp' => ['required', 'string', 'max:30'],
            'alamat' => ['required', 'string', 'max:500'],
            'latitude' => ['nullable', 'string', 'max:50'],
            'longitude' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih username lain.',
            'no_hp.required' => 'Nomor HP wajib diisi untuk konfirmasi pengiriman.',
            'alamat.required' => 'Alamat lengkap wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'password' => $validated['password'],
            'role' => 'pelanggan',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/')
            ->with('success', 'Akun pelanggan berhasil didaftarkan! Selamat datang di SIMANTAP, '.$user->nama.'.');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // 2. Coba login (remember me opsional)
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session (keamanan)
            $request->session()->regenerate();

            // Redirect sesuai role
            return $this->redirectByRole(Auth::user());
        }

        // 3. Kalau gagal, balik ke form dengan error
        return back()
            ->withInput($request->only('username', 'remember'))
            ->withErrors([
                'username' => 'Username atau password salah.',
            ]);
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout.');
    }

    /**
     * Redirect sesuai role dari database.
     */
    private function redirectByRole($user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin, '.$user->nama.'!'),
            'kasir' => redirect()->route('kasir.dashboard')->with('success', 'Selamat datang Kasir, '.$user->nama.'!'),
            default => redirect('/')->with('success', 'Selamat datang kembali, '.$user->nama.'!'),
        };
    }
}
