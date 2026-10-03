<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - SIMANTAP')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-100 min-h-screen">
    <div class="flex min-h-screen">

        <aside class="w-64 bg-green-800 text-white flex flex-col fixed h-full">
            <div class="p-6 border-b border-green-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">🌾</div>
                    <div>
                        <div class="font-bold text-lg">SIMANTAP</div>
                        <div class="text-xs text-green-200">Admin Panel</div>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-green-700">
                    <span>📊</span> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg opacity-50 cursor-not-allowed">
                    <span>📦</span> Produk <span class="text-xs ml-auto">(soon)</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg opacity-50 cursor-not-allowed">
                    <span>🛒</span> Pesanan <span class="text-xs ml-auto">(soon)</span>
                </a>
            </nav>

            <div class="p-4 border-t border-green-700">
                <div class="bg-green-900/50 rounded-lg p-3 mb-3">
                    <div id="user-name" class="text-sm font-semibold truncate">Admin</div>
                    <div class="text-xs text-green-300">👨‍💼 Administrator</div>
                </div>
                <button onclick="logout()"
                        class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition">
                    🚪 Logout
                </button>
            </div>
        </aside>

        <main class="flex-1 ml-64">
            <header class="bg-white shadow-sm border-b border-neutral-200 px-8 py-4">
                <h1 class="text-xl font-bold text-neutral-800">@yield('page-title', 'Dashboard')</h1>
                <p class="text-sm text-neutral-500">@yield('page-subtitle', 'Selamat datang di panel admin')</p>
            </header>
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
    function logout() {
        if (confirm('Yakin ingin logout?')) {
            localStorage.removeItem('simantap_user');
            window.location.href = '/login';
        }
    }
    </script>
</body>
</html>