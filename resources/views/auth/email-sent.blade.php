<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permintaan Terkirim - SIMANTAP</title>
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

            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <span class="text-4xl">✅</span>
            </div>

            <h1 class="text-2xl font-bold text-neutral-900 mb-2">Permintaan Terkirim!</h1>
            <p class="text-sm text-neutral-500 leading-relaxed mb-6">
                Permintaan reset password Anda sudah dikirim ke <strong>Admin</strong>.
                Mohon tunggu, admin akan segera memproses.
            </p>

            {{-- Info --}}
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-left mb-6">
                <div class="text-xs text-blue-800 leading-relaxed">
                    <p class="font-semibold mb-2">📋 Langkah Selanjutnya:</p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Admin akan menerima notifikasi permintaan Anda</li>
                        <li>Admin mereset password akun Anda</li>
                        <li>Anda akan dihubungi via telepon/WhatsApp</li>
                        <li>Login dengan password baru dari admin</li>
                    </ol>
                </div>
            </div>

            {{-- Tombol --}}
            <a href="{{ url('/login') }}"
               class="block w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20">
                ← Kembali ke Login
            </a>
        </div>

        <p class="text-center text-xs text-neutral-400 mt-6">
            © {{ date('Y') }} SIMANTAP. All rights reserved.
        </p>
    </div>

</body>
</html>