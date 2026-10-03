<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIMANTAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3 mb-2">
                <div class="w-14 h-14 bg-green-600 rounded-2xl flex items-center justify-center text-white text-3xl shadow-lg">
                    🌾
                </div>
                <span class="text-3xl font-extrabold text-green-700">SIMANTAP</span>
            </div>
            <p class="text-sm text-neutral-500">Sistem Informasi Manajemen Toko Alat Pertanian</p>
        </div>

        {{-- Card Login --}}
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-neutral-900 mb-1">Masuk ke Akun Anda</h1>
                <p class="text-sm text-neutral-500">Silakan login untuk melanjutkan</p>
            </div>

            {{-- Alert Sukses (setelah reset password) --}}
            <div id="alert-success" class="hidden bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm flex gap-2">
                <span>✅</span>
                <span>Password berhasil diubah. Silakan login menggunakan password baru.</span>
            </div>

            {{-- Alert Error --}}
            <div id="alert-error" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm flex gap-2">
                <span>⚠️</span>
                <span id="alert-message">Username atau password salah.</span>
            </div>

            {{-- Form Login --}}
            <form id="form-login" class="space-y-5">

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Username
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">
                            👤
                        </span>
                        <input type="text" id="username" required autofocus
                               placeholder="admin atau kasir"
                               autocomplete="username"
                               class="w-full pl-12 pr-4 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">
                            🔒
                        </span>
                        <input type="password" id="password" required
                               placeholder="••••••••"
                               autocomplete="current-password"
                               class="w-full pl-12 pr-12 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600 p-1">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember + Lupa Password --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember"
                               class="w-4 h-4 text-green-600 border-neutral-300 rounded focus:ring-green-500">
                        <label for="remember" class="ml-2 text-sm text-neutral-600">Ingat saya</label>
                    </div>
                    <a href="{{ url('/forgot-password') }}"
                       class="text-sm font-medium text-green-600 hover:text-green-700 hover:underline transition">
                        Lupa Password?
                    </a>
                </div>

                {{-- Submit --}}
                <button type="submit" id="btn-submit"
                        class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20 flex items-center justify-center gap-2">
                    <span>Masuk</span>
                </button>
            </form>

            {{-- Info Akun Demo --}}
            <div class="mt-6 pt-6 border-t border-neutral-100">
                <p class="text-xs text-neutral-500 text-center mb-3 font-semibold">🔑 AKUN DEMO</p>
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <button type="button" onclick="isiDemo('admin')"
                            class="bg-green-50 hover:bg-green-100 border border-green-100 rounded-lg p-3 text-left transition">
                        <div class="font-bold text-green-800 mb-1">👨‍💼 Admin</div>
                        <div class="text-neutral-600">Username: <strong>admin</strong></div>
                        <div class="text-neutral-600">Password: <strong>admin123</strong></div>
                    </button>
                    <button type="button" onclick="isiDemo('kasir')"
                            class="bg-blue-50 hover:bg-blue-100 border border-blue-100 rounded-lg p-3 text-left transition">
                        <div class="font-bold text-blue-800 mb-1">👨‍💻 Kasir</div>
                        <div class="text-neutral-600">Username: <strong>kasir</strong></div>
                        <div class="text-neutral-600">Password: <strong>kasir123</strong></div>
                    </button>
                </div>
                <p class="text-xs text-neutral-400 text-center mt-3">
                    💡 Klik salah satu untuk mengisi otomatis
                </p>
            </div>

            {{-- Kembali ke Beranda --}}
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="text-sm text-neutral-500 hover:text-green-600 transition">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-neutral-400 mt-6">
            © {{ date('Y') }} SIMANTAP. All rights reserved.
        </p>
    </div>

    <script>
    // ============================================
    // Kredensial Demo (Frontend Only)
    // ============================================
    const USERS = {
        'admin': { password: 'admin123', role: 'admin', name: 'Admin SIMANTAP', redirect: '/admin/dashboard' },
        'kasir': { password: 'kasir123', role: 'kasir', name: 'Kasir SIMANTAP', redirect: '/kasir/dashboard' }
    };

    // ============================================
    // Toggle Password Visibility
    // ============================================
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // ============================================
    // Isi Form Otomatis (Demo Button)
    // ============================================
    function isiDemo(role) {
        if (role === 'admin') {
            document.getElementById('username').value = 'admin';
            document.getElementById('password').value = 'admin123';
        } else if (role === 'kasir') {
            document.getElementById('username').value = 'kasir';
            document.getElementById('password').value = 'kasir123';
        }
        hideError();
        document.getElementById('password').focus();
    }

    // ============================================
    // Show / Hide Error
    // ============================================
    function showError(message) {
        document.getElementById('alert-message').textContent = message;
        document.getElementById('alert-error').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function hideError() {
        document.getElementById('alert-error').classList.add('hidden');
    }

    // ============================================
    // Cek Notifikasi Reset Password (?reset=success)
    // ============================================
    document.addEventListener('DOMContentLoaded', () => {
        const params = new URLSearchParams(window.location.search);
        if (params.get('reset') === 'success') {
            document.getElementById('alert-success').classList.remove('hidden');
            // Bersihkan query string dari URL
            window.history.replaceState({}, '', '{{ url("/login") }}');
            // Auto-hide setelah 8 detik
            setTimeout(() => {
                document.getElementById('alert-success').classList.add('hidden');
            }, 8000);
        }
    });

    // ============================================
    // Handle Submit Login
    // ============================================
    document.getElementById('form-login').addEventListener('submit', (e) => {
        e.preventDefault();
        hideError();

        const username = document.getElementById('username').value.trim().toLowerCase();
        const password = document.getElementById('password').value;
        const btn = document.getElementById('btn-submit');

        // Validasi input kosong
        if (!username) {
            showError('Username wajib diisi.');
            return;
        }

        if (!password) {
            showError('Password wajib diisi.');
            return;
        }

        // Loading state
        btn.disabled = true;
        btn.innerHTML = '<span>⏳</span> Memproses...';

        // Simulasi delay 600ms
        setTimeout(() => {
            const user = USERS[username];

            if (!user) {
                showError('Username tidak terdaftar. Coba gunakan akun demo di bawah.');
                btn.disabled = false;
                btn.innerHTML = '<span>Masuk</span>';
                return;
            }

            if (user.password !== password) {
                showError('Password salah. Silakan cek kembali atau klik "Lupa Password?".');
                btn.disabled = false;
                btn.innerHTML = '<span>Masuk</span>';
                return;
            }

            // Login berhasil — simpan session dummy
            localStorage.setItem('simantap_user', JSON.stringify({
                username: username,
                name: user.name,
                role: user.role,
                logged_at: new Date().toISOString()
            }));

            btn.innerHTML = '<span>✅</span> Berhasil! Mengalihkan...';
            setTimeout(() => {
                window.location.href = user.redirect;
            }, 500);

        }, 600);
    });

    // ============================================
    // Hide Error Ketika User Mulai Mengetik
    // ============================================
    document.getElementById('username').addEventListener('input', hideError);
    document.getElementById('password').addEventListener('input', hideError);
    </script>
</body>
</html>