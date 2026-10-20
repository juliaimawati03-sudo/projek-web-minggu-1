<footer id="kontak" class="bg-neutral-900 text-neutral-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid md:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">🌾</div>
                    <span class="font-bold text-xl text-white">SIMANTAP</span>
                </div>
                <p class="text-sm leading-relaxed max-w-md">
                    Sistem Informasi Manajemen Toko Alat Pertanian. Membantu petani dan pelanggan menemukan alat pertanian berkualitas dengan mudah.
                </p>
            </div>

            {{-- Navigasi --}}
            <div>
                <h4 class="font-bold text-white mb-4">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#beranda" class="hover:text-green-400 transition">Beranda</a></li>
                    <li><a href="#katalog" class="hover:text-green-400 transition">Katalog</a></li>
                    <li><a href="#tentang" class="hover:text-green-400 transition">Tentang Kami</a></li>
                    <li><a href="#kontak" class="hover:text-green-400 transition">Kontak</a></li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div>
                <h4 class="font-bold text-white mb-4">Kontak</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2">
                        <span>💬</span>
                        <a href="https://wa.me/{{ config('simantap.wa_number') }}" target="_blank" class="hover:text-green-400 transition">
                            +{{ config('simantap.wa_number') }}
                        </a>
                    </li>
                    <li class="flex items-start gap-2">
                        <span>📍</span>
                        <span>{{ config('simantap.store_address') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-neutral-800 mt-10 pt-6 text-center text-sm text-neutral-500">
            © {{ date('Y') }} SIMANTAP. Hak Cipta Dilindungi.
        </div>
    </div>
</footer>