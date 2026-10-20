<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-neutral-900 mb-2">Kategori Produk</h2>
            <p class="text-neutral-500">Pilih kategori untuk melihat produk yang sesuai</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($kategoriList as $kat)
                <button data-kategori="{{ $kat['id'] }}"
                        onclick="filterKategori('{{ $kat['id'] }}')"
                        class="kategori-btn group bg-neutral-50 hover:bg-green-600 border border-neutral-200 hover:border-green-600 rounded-2xl p-6 text-center transition-all duration-200">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition">{{ $kat['icon'] }}</div>
                    <div class="font-semibold text-sm text-neutral-800 group-hover:text-white transition">
                        {{ $kat['nama'] }}
                    </div>
                </button>
            @endforeach
        </div>
    </div>
</section>