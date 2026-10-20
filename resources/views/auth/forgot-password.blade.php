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

            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-full mb-4">
                    <span class="text-3xl">🔑</span>
                </div>
                <h1 class="text-2xl font-bold text-neutral-900 mb-2">Lupa Password?</h1>
                <p class="text-sm text-neutral-500 leading-relaxed">
                    Isi data di bawah. Admin akan menerima permintaan Anda dan segera membantu reset password.
                </p>
            </div>

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm flex gap-2">
                    <span>⚠️</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('password.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="username" required
                           value="{{ old('username') }}"
                           placeholder="Username akun Anda"
                           class="w-full px-4 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Nama Lengkap
                    </label>
                    <input type="text" name="nama"
                           value="{{ old('nama') }}"
                           placeholder="Nama Anda (opsional)"
                           class="w-full px-4 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">
                        No. Telepon / WhatsApp
                    </label>
                    <input type="tel" name="no_telepon"
                           value="{{ old('no_telepon') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">
                        Pesan Tambahan
                    </label>
                    <textarea name="pesan" rows="2"
                              placeholder="Contoh: Tolong reset password saya"
                              class="w-full px-4 py-3 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none">{{ old('pesan') }}</textarea>
                </div>

                <button type="submit"
                        class="w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20">
                    📧 Kirim Permintaan ke Admin
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-neutral-100 text-center">
                <a href="{{ url('/login') }}" class="text-sm text-neutral-500 hover:text-green-600 transition">
                    ← Kembali ke Login
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-neutral-400 mt-6">
            © {{ date('Y') }} SIMANTAP. All rights reserved.
        </p>
    </div>

</body>
</html>