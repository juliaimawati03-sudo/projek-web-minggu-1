<nav class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-neutral-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow">
                    🌾
                </div>
                <span class="font-bold text-xl text-green-700 tracking-tight">SIMANTAP</span>
            </a>

            {{-- Nav Links (Desktop) --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="#beranda" class="text-sm font-medium text-neutral-700 hover:text-green-600 transition">Beranda</a>
                <a href="#katalog" class="text-sm font-medium text-neutral-700 hover:text-green-600 transition">Katalog</a>
                <a href="#tentang" class="text-sm font-medium text-neutral-700 hover:text-green-600 transition">Tentang Kami</a>
                <a href="#kontak" class="text-sm font-medium text-neutral-700 hover:text-green-600 transition">Kontak</a>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                {{-- Cart Icon --}}
                <button onclick="openCart()" class="relative p-2 rounded-lg hover:bg-green-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-neutral-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 8m12-8l2 8m-6-8v8m-4-8v8" />
                    </svg>
                    <span id="cart-count" class="absolute -top-1 -right-1 bg-green-600 text-white text-xs font-bold rounded-full min-w-[20px] h-5 px-1 flex items-center justify-center">0</span>
                </button>

                @auth
                    {{-- User Dropdown / Profile --}}
                    <div class="relative" id="user-menu-wrapper">
                        <button onclick="document.getElementById('user-dropdown').classList.toggle('hidden')"
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-neutral-200 hover:border-green-500 bg-neutral-50 hover:bg-green-50 transition text-sm">
                            <span class="w-7 h-7 rounded-lg bg-green-600 text-white font-bold flex items-center justify-center text-xs">
                                {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                            </span>
                            <span class="font-medium text-neutral-800 max-w-[120px] truncate hidden sm:inline">
                                {{ Auth::user()->nama }}
                            </span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded font-semibold uppercase tracking-wider
                                  {{ Auth::user()->role === 'admin' ? 'bg-purple-100 text-purple-700' : (Auth::user()->role === 'kasir' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                                {{ Auth::user()->role }}
                            </span>
                            <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-neutral-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-neutral-100">
                                <p class="text-xs text-neutral-400">Masuk sebagai:</p>
                                <p class="text-sm font-bold text-neutral-800 truncate">{{ Auth::user()->nama }}</p>
                                <p class="text-xs text-neutral-500 font-mono">@<span>{{ Auth::user()->username }}</span></p>
                            </div>

                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-neutral-700 hover:bg-green-50 hover:text-green-700 transition">
                                    <span>⚙️</span> Dashboard Admin
                                </a>
                            @elseif (Auth::user()->role === 'kasir')
                                <a href="{{ route('kasir.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-neutral-700 hover:bg-green-50 hover:text-green-700 transition">
                                    <span>📠</span> Dashboard Kasir
                                </a>
                            @endif

                            <a href="{{ route('orders.my-orders') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-neutral-700 hover:bg-green-50 hover:text-green-700 transition">
                                <span>📦</span> Lacak Pesanan Saya
                            </a>

                            <div class="border-t border-neutral-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                    <span>🚪</span> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- Guest: Login & Register --}}
                    <div class="hidden sm:flex items-center gap-2">
                        <a href="{{ route('login') }}"
                           class="px-3.5 py-2 text-neutral-700 hover:text-green-600 font-semibold text-sm transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl transition shadow-sm shadow-green-600/20">
                            Daftar
                        </a>
                    </div>
                @endauth

                {{-- Mobile Menu Button --}}
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                        class="md:hidden p-2 rounded-lg hover:bg-neutral-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-neutral-100 pt-3">
            <div class="flex flex-col gap-2">
                <a href="{{ url('/#beranda') }}" class="px-3 py-2 rounded-lg hover:bg-green-50 text-sm font-medium">Beranda</a>
                <a href="{{ url('/#katalog') }}" class="px-3 py-2 rounded-lg hover:bg-green-50 text-sm font-medium">Katalog</a>
                <a href="{{ url('/#tentang') }}" class="px-3 py-2 rounded-lg hover:bg-green-50 text-sm font-medium">Tentang Kami</a>
                <a href="{{ url('/#kontak') }}" class="px-3 py-2 rounded-lg hover:bg-green-50 text-sm font-medium">Kontak</a>
                <a href="{{ route('orders.my-orders') }}" class="px-3 py-2 rounded-lg hover:bg-green-50 text-sm font-medium text-green-700 font-semibold">
                    📦 Lacak Pesanan Saya
                </a>

                @auth
                    <div class="pt-2 border-t border-neutral-200 mt-1">
                        <div class="px-3 py-1 text-xs text-neutral-500">Login sebagai: <strong>{{ Auth::user()->nama }} ({{ Auth::user()->role }})</strong></div>
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm text-purple-700 font-medium">Dashboard Admin</a>
                        @elseif (Auth::user()->role === 'kasir')
                            <a href="{{ route('kasir.dashboard') }}" class="block px-3 py-2 text-sm text-blue-700 font-medium">Dashboard Kasir</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 font-semibold">Keluar</button>
                        </form>
                    </div>
                @else
                    <div class="flex gap-2 pt-2 border-t border-neutral-100 mt-1">
                        <a href="{{ route('login') }}" class="flex-1 text-center py-2 border border-neutral-200 rounded-lg text-sm font-semibold">Masuk</a>
                        <a href="{{ route('register') }}" class="flex-1 text-center py-2 bg-green-600 text-white rounded-lg text-sm font-semibold">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>