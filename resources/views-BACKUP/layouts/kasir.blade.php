<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasir') | SIMANTAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        // Konfigurasi warna sama persis dengan layout admin, supaya panel kasir
        // terasa satu kesatuan desain dengan panel admin (bukan tema terpisah).
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        primary: {
                            dark: '#15803D',
                            DEFAULT: '#16A34A',
                            light: '#22C55E',
                            xlight: '#DCFCE7',
                            pale: '#F0FDF4',
                        },
                    },
                }
            }
        }
    </script>
    <style> body { font-family: 'Inter', sans-serif; } </style>
    @stack('styles')
</head>
<body class="bg-neutral-50 text-neutral-700 antialiased">

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

        {{-- Sidebar kasir — strukturnya identik dengan sidebar admin,
             hanya isi menu & route yang berbeda karena fungsi kasir berbeda dari admin --}}
        <aside class="fixed inset-y-0 left-0 z-30 w-64 bg-green-800 border-r border-green-700 flex flex-col
                       transform -translate-x-full lg:translate-x-0 transition-transform duration-200"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

            {{-- Brand, sama persis dengan admin, label diganti "Panel Kasir" --}}
            <div class="flex items-center gap-3 px-6 h-16 border-b border-green-700">
                <div class="w-9 h-9 rounded-lg bg-primary-light flex items-center justify-center font-bold text-green-900">S</div>
                <div>
                    <p class="text-white font-semibold leading-none">SIMANTAP</p>
                    <p class="text-green-200 text-xs mt-1">Panel Kasir</p>
                </div>
            </div>

            {{-- Menu navigasi kasir: Dashboard, Pesanan Masuk, Riwayat Transaksi --}}
            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
                <p class="px-3 text-[11px] font-semibold text-green-200 uppercase tracking-wide mb-2">Menu Utama</p>

                <a href="{{ route('kasir.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('kasir.dashboard') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700/60' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4a1 1 0 001-1v-4a1 1 0 011-1h0a1 1 0 011 1v4a1 1 0 001 1h4a1 1 0 001-1V10"/></svg>
                    Dashboard
                </a>

                <a href="{{ route('kasir.pesanan.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('kasir.pesanan.*') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700/60' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 14l6-6m-5-2h6a2 2 0 012 2v10a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2z"/></svg>
                    <span class="flex-1">Pesanan Masuk</span>
                    {{-- Badge jumlah pesanan menunggu, fungsinya tetap sama seperti versi lama --}}
                    @if(($pesananMasukCount ?? 3) > 0)
                        <span class="bg-red-600 text-white text-[11px] font-semibold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5">
                            {{ $pesananMasukCount ?? 3 }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('kasir.riwayat.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('kasir.riwayat.*') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700/60' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m4 6V7m4 10v-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Riwayat Transaksi
                </a>
            </nav>

            {{-- Kartu user + tombol logout, gaya & warna sama seperti sidebar admin
                 (card bg hijau transparan, tombol logout merah) --}}
            <div class="p-3 border-t border-green-700">
                <div class="flex items-center gap-3 rounded-lg px-3 py-3" style="background-color: rgba(20,83,45,0.5);">
                    <div class="w-9 h-9 rounded-full bg-primary-light flex items-center justify-center text-sm font-semibold text-green-900">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'K', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-medium truncate">{{ auth()->user()->nama ?? 'Kasir SIMANTAP' }}</p>
                        <p class="text-green-200 text-xs truncate">{{ ucfirst(auth()->user()->role ?? 'kasir') }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2.5 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-20 lg:hidden"></div>

        {{-- Area konten utama, topbar sama persis dengan admin --}}
        <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
            <header class="h-16 bg-white border-b border-neutral-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden text-neutral-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h1 class="text-neutral-800 font-semibold text-lg leading-none">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-neutral-500 text-xs mt-1">@yield('page-desc', '')</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline text-sm text-neutral-500">{{ now()->translatedFormat('l, d F Y') }}</span>
                    <div class="w-9 h-9 rounded-full bg-primary-xlight text-primary-dark flex items-center justify-center font-semibold text-sm">
                        {{ strtoupper(substr(auth()->user()->nama ?? 'K', 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6">
                @if(session('success'))
                    <div class="mb-4 flex items-center gap-2 rounded-lg bg-primary-xlight border border-primary-light/40 text-primary-dark text-sm px-4 py-3">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>
</html>