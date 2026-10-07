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

            {{-- Alert Sukses --}}
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm flex gap-2">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm flex gap-2">
                    <span>⚠️</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                @csrf

                {{-- Username --}}
                <div>
                    <label for="username" class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Username
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">👤</span>
                        <input type="text" id="username" name="username"
                               value="{{ old('username') }}"
                               required autofocus
                               placeholder="Masukkan username Anda"
                               class="w-full pl-12 pr-4 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">🔒</span>
                        <input type="password" id="password" name="password"
                               required
                               placeholder="••••••••"
                               class="w-full pl-12 pr-12 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600 p-1">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember + Lupa Password --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                               class="w-4 h-4 text-green-600 border-neutral-300 rounded focus:ring-green-500">
                        <label for="remember" class="ml-2 text-sm text-neutral-600">Ingat saya</label>
                    </div>
                    <a href="{{ url('/forgot-password') }}"
                       class="text-sm font-medium text-green-600 hover:text-green-700 hover:underline transition">
                        Lupa Password?
                    </a>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20">
                    Masuk
                </button>
            </form>

            {{-- Info --}}
            <div class="mt-6 pt-6 border-t border-neutral-100">
                <p class="text-xs text-neutral-500 text-center">
                    Belum punya akun? Hubungi <strong>Administrator</strong> toko.
                </p>
            </div>

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
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
    </script>
</body>
</html>