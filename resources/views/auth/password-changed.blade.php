<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Berhasil Diubah - SIMANTAP</title>
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
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

            {{-- Ikon Sukses --}}
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-neutral-900 mb-2">Password Berhasil Diubah!</h1>
            <p class="text-sm text-neutral-500 leading-relaxed mb-6">
                Password akun Anda telah berhasil diperbarui. Silakan login menggunakan password baru Anda.
            </p>

            {{-- Info --}}
            <div class="bg-green-50 border border-green-100 rounded-xl p-4 flex gap-3 mb-6 text-left">
                <span class="text-green-600 text-xl shrink-0">🔒</span>
                <div class="text-xs text-green-800 leading-relaxed">
                    <p class="font-semibold mb-1">Akun Anda aman</p>
                    <p>Jika Anda tidak melakukan perubahan ini, segera hubungi Administrator toko.</p>
                </div>
            </div>

            {{-- Tombol Login --}}
            <a href="{{ url('/login?reset=success') }}"
               class="block w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20">
                🔓 Login Sekarang
            </a>

            {{-- Tombol Kontak Admin --}}
            <div class="mt-4 text-center">
                <p class="text-xs text-neutral-400 mb-2">Bukan Anda yang mengubah?</p>
                <a href="https://wa.me/6287859563173?text=Halo%20Admin,%20saya%20khawatir%20password%20akun%20saya%20berubah%20tanpa%20sepengetahuan%20saya."
                   target="_blank"
                   class="inline-flex items-center gap-1 text-xs text-red-500 hover:text-red-700 font-semibold transition">
                    <span>⚠️</span> Hubungi Admin Sekarang
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-neutral-400 mt-6">
            © {{ date('Y') }} SIMANTAP. All rights reserved.
        </p>
    </div>

</body>
</html>