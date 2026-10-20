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

                {{-- Login --}}
                <a href="{{ Route::has('login') ? route('login') : '#' }}"
                   class="hidden sm:inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition shadow-sm">
                    Masuk
                </a>

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
                <a href="#beranda" class="px-3 py-2 rounded-lg hover:bg-green-50 text-sm font-medium">Beranda</a>
                <a href="#katalog" class="px-3 py-2 rounded-lg hover:bg-green-50 text-sm font-medium">Katalog</a>
                <a href="#tentang" class="px-3 py-2 rounded-lg hover:bg-green-50 text-sm font-medium">Tentang Kami</a>
                <a href="#kontak" class="px-3 py-2 rounded-lg hover:bg-green-50 text-sm font-medium">Kontak</a>
                <a href="{{ Route::has('login') ? route('login') : '#' }}"
                   class="mt-1 px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg text-center">Masuk</a>
            </div>
        </div>
    </div>
</nav>