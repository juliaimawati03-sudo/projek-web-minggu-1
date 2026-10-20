<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password - SIMANTAP</title>
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

            {{-- Ikon --}}
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                    <span class="text-3xl">🔑</span>
                </div>
                <h1 class="text-2xl font-bold text-neutral-900 mb-2">Lupa Password?</h1>
                <p class="text-sm text-neutral-500 leading-relaxed">
                    Masukkan email yang terdaftar pada akun Anda. Kami akan mengirimkan link untuk mengatur ulang password.
                </p>
            </div>

            {{-- Alert Error --}}
            <div id="alert-error" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm flex gap-2">
                <span>⚠️</span>
                <span id="alert-message">Email tidak valid.</span>
            </div>

            {{-- Form --}}
            <form id="form-forgot" class="space-y-5">

                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Email Terdaftar
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">
                            ✉️
                        </span>
                        <input type="email" id="email" required autofocus
                               placeholder="nama@email.com"
                               class="w-full pl-12 pr-4 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    </div>
                    <p class="text-xs text-neutral-500 mt-2">
                        💡 Gunakan email yang Anda pakai saat mendaftar akun.
                    </p>
                </div>

                <button type="submit" id="btn-submit"
                        class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20 flex items-center justify-center gap-2">
                    <span>📧 Kirim Link Reset Password</span>
                </button>
            </form>

            {{-- Info Keamanan --}}
            <div class="mt-6 bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3">
                <span class="text-blue-500 text-xl shrink-0">🔒</span>
                <div class="text-xs text-blue-800 leading-relaxed">
                    <p class="font-semibold mb-1">Aman & Terlindungi</p>
                    <p>Demi keamanan, kami tidak akan memberitahu apakah email terdaftar atau tidak. Cek inbox Anda dalam beberapa menit.</p>
                </div>
            </div>

            {{-- Kembali ke Login --}}
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
    document.getElementById('form-forgot').addEventListener('submit', (e) => {
        e.preventDefault();
        document.getElementById('alert-error').classList.add('hidden');

        const email = document.getElementById('email').value.trim();
        const btn = document.getElementById('btn-submit');

        // Validasi format email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            document.getElementById('alert-message').textContent = 'Format email tidak valid.';
            document.getElementById('alert-error').classList.remove('hidden');
            return;
        }

        // Loading
        btn.disabled = true;
        btn.innerHTML = '<span>⏳</span> Mengirim...';

        // Simulasi kirim (backend nanti)
        setTimeout(() => {
            // Simpan email di localStorage untuk demo
            localStorage.setItem('simantap_reset_email', email);
            window.location.href = "{{ url('/forgot-password/sent') }}";
        }, 800);
    });
    </script>
</body>
</html>