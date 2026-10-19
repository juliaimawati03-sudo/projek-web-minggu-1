<section id="katalog" class="py-14 bg-neutral-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between mb-10 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-neutral-900 mb-2">Katalog Produk</h2>
                <p class="text-neutral-500">Pilih produk, tambahkan ke keranjang, lalu pesan via WhatsApp</p>
            </div>
            <button onclick="filterKategori('all')"
                    class="text-sm font-medium text-green-600 hover:text-green-700 underline underline-offset-4">
                Tampilkan Semua
            </button>
        </div>

        <div id="produk-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($produkList as $produk)
                @php
                    $nama = $produk->nama_produk ?? $produk->nama ?? 'Alat Pertanian';
                    $gambar = $produk->gambar ? asset('storage/' . $produk->gambar) : 'https://images.unsplash.com/photo-1592417817098-8f3d6ef2393c?w=400&auto=format&fit=crop&q=60';
                    $kategori = $produk->kategori ?? 'pertanian';
                @endphp
                <div class="produk-card bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col"
                     data-kategori="{{ $kategori }}">

                    {{-- Foto --}}
                    <div class="relative aspect-square overflow-hidden bg-neutral-100">
                        <img src="{{ $gambar }}" alt="{{ $nama }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                             loading="lazy">
                        <span class="absolute top-3 left-3 px-2.5 py-1 text-xs font-semibold rounded-full
                            {{ $produk->stok ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                            {{ $produk->stok ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>

                    {{-- Info --}}
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="font-bold text-neutral-900 text-lg mb-1">{{ $nama }}</h3>
                        <p class="text-sm text-neutral-500 mb-4 line-clamp-2 flex-1">{{ $produk->deskripsi ?? 'Alat pertanian berkualitas tinggi untuk efisiensi bertani Anda.' }}</p>

                        <div class="text-xl font-extrabold text-green-600 mb-4">
                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                        </div>

                        <div class="space-y-2">
                            <button onclick='tambahKeKeranjang({ id: {{ $produk->id }}, nama: @json($nama), harga: {{ $produk->harga }}, stok: {{ $produk->stok }}, gambar: @json($gambar) })'
                                    {{ !$produk->stok ? 'disabled' : '' }}
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-600 hover:bg-green-700 disabled:bg-neutral-300 disabled:cursor-not-allowed text-white text-sm font-semibold rounded-lg transition shadow-sm">
                                <span>🛒</span> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Empty state --}}
        <div id="empty-kategori" class="hidden text-center py-16">
            <div class="text-5xl mb-3">📦</div>
            <p class="text-neutral-500">Belum ada produk untuk kategori ini.</p>
        </div>
    </div>
</section>