<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - SIMANTAP</title>
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

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl p-8">

            {{-- Header --}}
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <span class="text-3xl">🔒</span>
                </div>
                <h1 class="text-2xl font-bold text-neutral-900 mb-2">Reset Password</h1>
                <p class="text-sm text-neutral-500">Masukkan password baru untuk akun Anda</p>
            </div>

            {{-- Info User --}}
            <div class="bg-neutral-50 border border-neutral-100 rounded-xl p-3 mb-6">
                <div class="text-xs text-neutral-500 mb-0.5">Reset password untuk:</div>
                <div id="email-info" class="font-semibold text-neutral-800 text-sm break-all">
                    -
                </div>
            </div>

            {{-- Alert Error --}}
            <div id="alert-error" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm flex gap-2">
                <span>⚠️</span>
                <span id="alert-message">Password tidak valid.</span>
            </div>

            {{-- Form --}}
            <form id="form-reset" class="space-y-5">

                {{-- Password Baru --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" id="password" required autofocus
                               placeholder="••••••••"
                               class="w-full px-4 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition pr-12">
                        <button type="button" onclick="togglePassword('password')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600 p-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Konfirmasi Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" required
                               placeholder="••••••••"
                               class="w-full px-4 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition pr-12">
                        <button type="button" onclick="togglePassword('password_confirmation')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600 p-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Indikator Kekuatan Password --}}
                <div id="strength-indicator" class="hidden">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-neutral-500">Kekuatan Password:</span>
                        <span id="strength-text" class="text-xs font-semibold">-</span>
                    </div>
                    <div class="h-1.5 bg-neutral-200 rounded-full overflow-hidden">
                        <div id="strength-bar" class="h-full w-0 transition-all duration-300"></div>
                    </div>
                </div>

                {{-- Syarat Password --}}
                <div class="bg-neutral-50 border border-neutral-100 rounded-xl p-4">
                    <p class="text-xs font-semibold text-neutral-700 mb-2">Password harus:</p>
                    <ul class="space-y-1 text-xs">
                        <li id="req-length" class="flex items-center gap-2 text-neutral-500">
                            <span class="w-4 h-4 rounded-full bg-neutral-300 flex items-center justify-center text-white text-[10px]">✓</span>
                            Minimal 8 karakter
                        </li>
                        <li id="req-letter" class="flex items-center gap-2 text-neutral-500">
                            <span class="w-4 h-4 rounded-full bg-neutral-300 flex items-center justify-center text-white text-[10px]">✓</span>
                            Mengandung huruf
                        </li>
                        <li id="req-number" class="flex items-center gap-2 text-neutral-500">
                            <span class="w-4 h-4 rounded-full bg-neutral-300 flex items-center justify-center text-white text-[10px]">✓</span>
                            Mengandung angka
                        </li>
                    </ul>
                </div>

                <button type="submit" id="btn-submit"
                        class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20 flex items-center justify-center gap-2">
                    <span>✓ Simpan Password Baru</span>
                </button>
            </form>

            {{-- Kembali --}}
            <div class="mt-6 text-center">
                <a href="{{ url('/login') }}" class="text-sm text-neutral-500 hover:text-green-600 transition">
                    ← Kembali ke Login
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-neutral-400 mt-6">
            © {{ date('Y') }} SIMANTAP. All rights reserved.
        </p>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Tampilkan email yang direset (dari localStorage)
        const email = localStorage.getItem('simantap_reset_email');
        if (email) {
            document.getElementById('email-info').textContent = email;
        }

        // Setup password strength
        const passwordInput = document.getElementById('password');
        passwordInput.addEventListener('input', updateStrength);

        // Setup requirement checklist
        passwordInput.addEventListener('input', checkRequirements);
    });

    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function updateStrength() {
        const password = document.getElementById('password').value;
        const indicator = document.getElementById('strength-indicator');
        const bar = document.getElementById('strength-bar');
        const text = document.getElementById('strength-text');

        if (password.length === 0) {
            indicator.classList.add('hidden');
            return;
        }

        indicator.classList.remove('hidden');

        let score = 0;
        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
        if (/\d/.test(password)) score++;
        if (/[^a-zA-Z\d]/.test(password)) score++;

        bar.className = 'h-full transition-all duration-300';

        if (score <= 2) {
            bar.classList.add('bg-red-500');
            bar.style.width = '33%';
            text.textContent = 'Lemah';
            text.className = 'text-xs font-semibold text-red-500';
        } else if (score <= 4) {
            bar.classList.add('bg-yellow-500');
            bar.style.width = '66%';
            text.textContent = 'Sedang';
            text.className = 'text-xs font-semibold text-yellow-500';
        } else {
            bar.classList.add('bg-green-500');
            bar.style.width = '100%';
            text.textContent = 'Kuat';
            text.className = 'text-xs font-semibold text-green-500';
        }
    }

    function checkRequirements() {
        const password = document.getElementById('password').value;

        check('req-length', password.length >= 8);
        check('req-letter', /[a-zA-Z]/.test(password));
        check('req-number', /\d/.test(password));
    }

    function check(id, ok) {
        const li = document.getElementById(id);
        const icon = li.querySelector('span');

        if (ok) {
            li.classList.remove('text-neutral-500');
            li.classList.add('text-green-600');
            icon.classList.remove('bg-neutral-300');
            icon.classList.add('bg-green-500');
        } else {
            li.classList.remove('text-green-600');
            li.classList.add('text-neutral-500');
            icon.classList.remove('bg-green-500');
            icon.classList.add('bg-neutral-300');
        }
    }

    // Handle submit
    document.getElementById('form-reset').addEventListener('submit', (e) => {
        e.preventDefault();
        document.getElementById('alert-error').classList.add('hidden');

        const password = document.getElementById('password').value;
        const confirmation = document.getElementById('password_confirmation').value;
        const btn = document.getElementById('btn-submit');

        // Validasi
        if (password.length < 8) {
            showError('Password minimal 8 karakter.');
            return;
        }

        if (!/[a-zA-Z]/.test(password)) {
            showError('Password harus mengandung huruf.');
            return;
        }

        if (!/\d/.test(password)) {
            showError('Password harus mengandung angka.');
            return;
        }

        if (password !== confirmation) {
            showError('Konfirmasi password tidak cocok.');
            return;
        }

        // Loading
        btn.disabled = true;
        btn.innerHTML = '<span>⏳</span> Menyimpan...';

        // Simulasi simpan
        setTimeout(() => {
            // Clear data demo
            localStorage.removeItem('simantap_reset_email');
            window.location.href = "{{ url('/password-changed') }}";
        }, 1000);
    });

    function showError(message) {
        document.getElementById('alert-message').textContent = message;
        document.getElementById('alert-error').classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    </script>
</body>
</html>