@extends('layouts.app')

@section('title', 'Form Pemesanan & Pengiriman - SIMANTAP')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .leaflet-container {
        font-family: inherit;
        z-index: 10;
    }
    .payment-option input:checked + div {
        border-color: #16a34a;
        background-color: #f0fdf4;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
    }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    {{-- Tombol Kembali --}}
    <a href="{{ url('/') }}"
       class="inline-flex items-center gap-2 text-sm text-neutral-600 hover:text-green-600 mb-6 transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Katalog
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-6 py-5 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-1">📋 Form Pemesanan & Pengiriman</h1>
                    <p class="text-green-100 text-sm">Lengkapi data pemesanan, pilih opsi pengiriman & ongkir</p>
                </div>
                <div class="hidden sm:block text-3xl">🌾</div>
            </div>
        </div>

        <form id="form-pemesanan" class="p-6 space-y-6">

            {{-- Status Akun Pelanggan --}}
            @auth
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center justify-between flex-wrap gap-2">
                    <div class="flex items-center gap-3">
                        <span class="w-9 h-9 rounded-full bg-green-600 text-white flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                        </span>
                        <div>
                            <p class="text-sm text-green-900 font-semibold">
                                Masuk sebagai: {{ Auth::user()->nama }}
                                <span class="ml-1 text-xs px-2 py-0.5 bg-green-200 text-green-800 rounded-full uppercase font-bold">{{ Auth::user()->role }}</span>
                            </p>
                            <p class="text-xs text-green-700">Data Anda dan titik koordinat otomatis dimuat ke formulir.</p>
                        </div>
                    </div>
                    <span class="text-xs text-neutral-500 font-mono">@<span>{{ Auth::user()->username }}</span></span>
                </div>
            @else
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-center justify-between flex-wrap gap-2 text-sm text-amber-900">
                    <div class="flex items-center gap-2">
                        <span>💡</span>
                        <span>Sudah punya akun pelanggan?</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="font-bold underline hover:text-amber-700">Masuk</a>
                        <span class="text-neutral-400">•</span>
                        <a href="{{ route('register') }}" class="font-bold underline hover:text-amber-700">Daftar Akun Baru</a>
                    </div>
                </div>
            @endauth

            {{-- ===== DAFTAR PRODUK ===== --}}
            <div>
                <h2 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>🛒</span> Produk Pesanan
                </h2>
                <div id="daftar-produk" class="space-y-3"></div>

                <div id="produk-kosong" class="hidden text-center py-8 text-neutral-500">
                    <div class="text-4xl mb-2">📦</div>
                    <p>Keranjang masih kosong</p>
                    <a href="{{ url('/') }}" class="text-green-600 underline mt-2 inline-block">
                        Pilih produk dulu
                    </a>
                </div>
            </div>

            {{-- ===== DATA PELANGGAN ===== --}}
            <div class="pt-4 border-t border-neutral-100">
                <h2 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>👤</span> Data Pelanggan
                </h2>

                <div class="space-y-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-neutral-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama" required
                               value="{{ auth()->check() ? auth()->user()->nama : '' }}"
                               placeholder="Contoh: Budi Santoso"
                               class="w-full px-4 py-2.5 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label for="hp" class="block text-sm font-medium text-neutral-700 mb-1">
                            Nomor WhatsApp / HP <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" id="hp" name="hp" required
                               value="{{ auth()->check() ? auth()->user()->no_hp : '' }}"
                               placeholder="Contoh: 081234567890"
                               class="w-full px-4 py-2.5 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-neutral-700 mb-1">
                            Alamat Pengantaran / Domisili <span class="text-red-500">*</span>
                        </label>
                        <textarea id="alamat" name="alamat" required rows="2"
                                  placeholder="Contoh: Jl. Pertanian No. 123, RT 01/RW 02, Desa Sukamaju"
                                  class="w-full px-4 py-2.5 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none">{{ auth()->check() ? auth()->user()->alamat : '' }}</textarea>
                    </div>

                    {{-- Titik Koordinat Pelanggan (Pin Marker Pengantaran) --}}
                    <div class="bg-neutral-50 rounded-xl p-4 border border-neutral-200">
                        <div class="flex items-center justify-between flex-wrap gap-2 mb-2">
                            <label class="block text-sm font-bold text-neutral-800">
                                <span class="text-green-600">📍</span> Titik Koordinat Pelanggan (Pin Marker Peta)
                            </label>
                            <button type="button" onclick="deteksiLokasiPelanggan()"
                                    class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-lg bg-green-100 text-green-800 hover:bg-green-200 border border-green-300 transition">
                                <span id="gps-icon">🎯</span> <span id="gps-label">Gunakan Lokasi GPS Saya</span>
                            </button>
                        </div>
                        <p class="text-xs text-neutral-500 mb-3">
                            Geser pin marker merah atau klik langsung pada peta di bawah ini untuk menentukan titik koordinat rumah atau lahan pertanian Anda.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-2">
                            <div>
                                <label for="pelanggan-lat" class="block text-xs font-medium text-neutral-600 mb-0.5">Latitude</label>
                                <input type="text" id="pelanggan-lat" name="latitude"
                                       value="{{ auth()->check() ? auth()->user()->latitude : '' }}"
                                       placeholder="-7.546835"
                                       class="w-full px-3 py-1.5 text-xs font-mono font-bold text-neutral-800 border border-neutral-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-green-500 bg-white">
                            </div>
                            <div>
                                <label for="pelanggan-lng" class="block text-xs font-medium text-neutral-600 mb-0.5">Longitude</label>
                                <input type="text" id="pelanggan-lng" name="longitude"
                                       value="{{ auth()->check() ? auth()->user()->longitude : '' }}"
                                       placeholder="112.226512"
                                       class="w-full px-3 py-1.5 text-xs font-mono font-bold text-neutral-800 border border-neutral-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-green-500 bg-white">
                            </div>
                        </div>

                        {{-- Map Container Pelanggan --}}
                        <div id="map-pelanggan" class="w-full h-48 rounded-xl border border-neutral-300 shadow-inner overflow-hidden relative"></div>
                    </div>

                    <div>
                        <label for="catatan" class="block text-sm font-medium text-neutral-700 mb-1">
                            Catatan Tambahan <span class="text-neutral-400">(opsional)</span>
                        </label>
                        <textarea id="catatan" name="catatan" rows="2"
                                  placeholder="Contoh: Titipkan di pos satpam atau tolong antar sebelum jam 12 siang"
                                  class="w-full px-4 py-2.5 border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none"></textarea>
                    </div>
                </div>
            </div>

            {{-- ===== OPSI PENGIRIMAN & ONGKIR ===== --}}
            <div class="pt-4 border-t border-neutral-100">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="font-bold text-neutral-800 flex items-center gap-2">
                        <span>🚚</span> Metode Pengiriman & Ongkir
                    </h2>
                    <span class="text-xs text-neutral-500">Pilih opsi pengantaran</span>
                </div>
                <p class="text-sm text-neutral-500 mb-4">Pilih apakah barang ingin diambil langsung atau diantar ke alamat Anda:</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3" id="shipping-options-container">

                    <!-- 1. Ambil di Toko -->
                    <label class="shipping-option cursor-pointer block">
                        <input type="radio" name="shipping_method" value="pickup" data-cost="0" data-label="Ambil Sendiri di Toko" data-type="Ambil di Toko" class="sr-only" checked onchange="handleShippingChange()">
                        <div class="p-4 border-2 border-green-600 bg-green-50/60 rounded-xl transition hover:border-green-600 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-2xl">🏪</span>
                                    <span class="text-xs font-bold px-2 py-0.5 bg-green-100 text-green-700 rounded-full">Gratis</span>
                                </div>
                                <div class="font-bold text-neutral-800 text-sm">Ambil di Toko</div>
                                <div class="text-xs text-neutral-500 mt-1">Barang disiapkan di toko SIMANTAP</div>
                            </div>
                            <div class="font-extrabold text-green-700 text-base mt-3" id="harga-pickup">Rp0</div>
                        </div>
                    </label>

                    <!-- 2. Kurir Toko -->
                    <label class="shipping-option cursor-pointer block">
                        <input type="radio" name="shipping_method" value="kurir_toko" data-cost="15000" data-label="Kurir Toko (Diantar Langsung)" data-type="Barang Diantar" class="sr-only" onchange="handleShippingChange()">
                        <div class="p-4 border-2 border-neutral-200 rounded-xl transition hover:border-green-500 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-2xl">🛵</span>
                                    <span class="text-xs font-bold px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full">Diantar Cepat</span>
                                </div>
                                <div class="font-bold text-neutral-800 text-sm">Kurir Toko</div>
                                <div class="text-xs text-neutral-500 mt-1">Diantar langsung ke alamat rumah Anda</div>
                            </div>
                            <div class="font-extrabold text-neutral-800 text-base mt-3" id="harga-kurir">Rp15.000</div>
                        </div>
                    </label>

                    <!-- 3. J&T Reguler -->
                    <label class="shipping-option cursor-pointer block">
                        <input type="radio" name="shipping_method" value="jnt_reguler" data-label="Ekspedisi J&T Reguler" data-type="Barang Diantar" class="sr-only" onchange="handleShippingChange()">
                        <div class="p-4 border-2 border-neutral-200 rounded-xl transition hover:border-green-500 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-2xl">📦</span>
                                    <span class="text-xs font-bold px-2 py-0.5 bg-red-100 text-red-700 rounded-full">Reguler</span>
                                </div>
                                <div class="font-bold text-neutral-800 text-sm">Ekspedisi J&T</div>
                                <div class="text-xs text-neutral-500 mt-1">Dihitung per-jarak (mulai Rp10.000)</div>
                            </div>
                            <div class="font-extrabold text-neutral-800 text-base mt-3" id="harga-jnt-reguler">Hitung Otomatis</div>
                        </div>
                    </label>

                    <!-- 4. J&T Cargo -->
                    <label class="shipping-option cursor-pointer block">
                        <input type="radio" name="shipping_method" value="jnt_cargo" data-label="Ekspedisi J&T Cargo (Min. 10 Kg)" data-type="Barang Diantar" class="sr-only" onchange="handleShippingChange()">
                        <div class="p-4 border-2 border-neutral-200 rounded-xl transition hover:border-green-500 h-full flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-2xl">🚛</span>
                                    <span class="text-xs font-bold px-2 py-0.5 bg-purple-100 text-purple-700 rounded-full">Kargo Luar Area</span>
                                </div>
                                <div class="font-bold text-neutral-800 text-sm">J&T Cargo</div>
                                <div class="text-xs text-neutral-500 mt-1">Barang berat (mulai Rp6.500/kg)</div>
                            </div>
                            <div class="font-extrabold text-neutral-800 text-base mt-3" id="harga-jnt-cargo">Hitung Otomatis</div>
                        </div>
                    </label>
                </div>

                <!-- INPUT BERAT BARANG (Khusus J&T Cargo) -->
                <div id="input-berat-container" class="mt-4 hidden bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <label class="block text-sm font-medium text-amber-900 mb-1">
                        Berat Barang (Kg) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="berat_barang" id="berat_barang" min="1" step="1" value="10"
                           class="w-full px-4 py-2.5 border border-amber-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <p class="text-xs text-amber-600 mt-1">Minimal pengiriman J&T Cargo adalah 10 Kg.</p>
                </div>

                {{-- Notifikasi Keterangan Status Pengantaran --}}
                <div id="notif-pengiriman-box" class="mt-3 p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-900 flex items-start gap-2.5">
                    <span class="text-lg shrink-0">🔔</span>
                    <div>
                        <span class="font-bold" id="notif-status-badge">Keterangan: Barang Diproses & Siap Diambil</span>
                        <p class="mt-0.5 text-emerald-800" id="notif-status-desc">
                            Setelah pembayaran diverifikasi, pesanan Anda akan <strong>diproses & disiapkan</strong> di toko. Anda dapat mengambilnya langsung di toko SIMANTAP.
                        </p>
                    </div>
                </div>

                {{-- ===== TITIK KOORDINAT MAPS TOKO ===== --}}
                <div id="kotak-toko-section" class="mt-4 p-5 rounded-2xl border-2 transition-all bg-emerald-50/40 border-emerald-300">
                    <div class="flex items-start justify-between flex-wrap gap-2 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-green-600 to-emerald-700 text-white flex items-center justify-center text-xl shadow-md shrink-0">
                                🏪
                            </div>
                            <div>
                                <h3 class="font-bold text-neutral-900 text-base leading-tight">
                                    Lokasi & Titik Koordinat Toko {{ config('simantap.store_name') }}
                                </h3>
                                <p class="text-xs text-neutral-500 mt-0.5">
                                    Titik koordinat resmi toko fisik & lokasi awal pengiriman
                                </p>
                            </div>
                        </div>

                        {{-- Titik Koordinat Badge & Copy Button --}}
                        <div class="flex items-center gap-2">
                            <div class="bg-white border border-emerald-300 rounded-lg px-2.5 py-1 text-xs font-mono font-bold text-emerald-800 shadow-sm flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span id="label-toko-koordinat">{{ config('simantap.store_latitude') }}, {{ config('simantap.store_longitude') }}</span>
                            </div>
                            <button type="button" onclick="salinKoordinatToko()"
                                    class="text-xs font-semibold px-2.5 py-1 bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-300 rounded-lg shadow-sm transition flex items-center gap-1"
                                    title="Salin titik koordinat toko">
                                <span id="copy-toko-icon">📋</span> <span id="copy-toko-text">Salin</span>
                            </button>
                        </div>
                    </div>

                    {{-- Rincian Alamat Toko --}}
                    <div class="bg-white/90 rounded-xl p-3 border border-emerald-100 text-xs space-y-1.5 mb-3 text-neutral-700">
                        <div class="flex items-start gap-2">
                            <span class="text-neutral-400 font-bold shrink-0">📍 Alamat Toko:</span>
                            <span class="font-semibold text-neutral-800">{{ config('simantap.store_address') }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-neutral-500 pt-1 border-t border-emerald-50 flex-wrap">
                            <span>⏰ Jam Operasional: Senin - Sabtu (08.00 - 17.00 WIB)</span>
                            <span>📞 WhatsApp CS: +{{ config('simantap.wa_number') }}</span>
                        </div>
                    </div>

                    {{-- Pesan Dinamis Mode Pengiriman --}}
                    <div id="pesan-mode-pengiriman-toko" class="mb-3 px-3 py-2 rounded-lg bg-green-100/90 border border-green-300 text-xs font-medium text-green-900 flex items-center gap-2">
                        <span class="text-base shrink-0">📌</span>
                        <span id="teks-keterangan-toko">Anda memilih <strong>Ambil Sendiri di Toko</strong>. Silakan kunjungi lokasi titik koordinat toko pada peta di bawah saat pesanan Anda siap diambil.</span>
                    </div>

                    {{-- Container Map Toko --}}
                    <div class="relative rounded-xl overflow-hidden border border-emerald-300 shadow-sm">
                        <div id="map-toko" class="w-full h-56 bg-neutral-100 z-0"></div>

                        {{-- Tombol Buka di Google Maps --}}
                        <div class="absolute bottom-3 right-3 z-[400]">
                            <a href="{{ config('simantap.store_maps_url') }}"
                               target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-lg text-xs font-bold transition hover:scale-105 active:scale-95">
                                <span>🗺️</span> Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== METODE PEMBAYARAN ===== --}}
            <div class="pt-4 border-t border-neutral-100">
                <h2 class="font-bold text-neutral-800 mb-3 flex items-center gap-2">
                    <span>💳</span> Metode Pembayaran
                </h2>
                <p class="text-sm text-neutral-500 mb-4">Pilih salah satu metode pembayaran di bawah ini:</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    {{-- ShopeePay --}}
                    <label class="payment-option cursor-pointer">
                        <input type="radio" name="payment_method" value="ShopeePay" class="sr-only" required>
                        <div class="flex items-center gap-3 p-4 border-2 border-neutral-200 rounded-xl hover:border-orange-400 transition">
                            <div class="w-14 h-14 rounded-lg bg-white flex items-center justify-center shrink-0 overflow-hidden border border-neutral-100 p-1">
                                <img src="{{ asset('images/shopeepay.png') }}"
                                     alt="ShopeePay"
                                     class="w-full h-full object-contain">
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="font-bold text-neutral-800">ShopeePay</div>
                                <div class="text-xs text-neutral-500 font-mono">0878-5956-3173</div>
                            </div>
                        </div>
                    </label>

                    {{-- SeaBank --}}
                    <label class="payment-option cursor-pointer">
                        <input type="radio" name="payment_method" value="SeaBank" class="sr-only">
                        <div class="flex items-center gap-3 p-4 border-2 border-neutral-200 rounded-xl hover:border-orange-400 transition">
                            <div class="w-14 h-14 rounded-lg bg-white flex items-center justify-center shrink-0 overflow-hidden border border-neutral-100 p-1">
                                <img src="{{ asset('images/seabank.png') }}"
                                     alt="SeaBank"
                                     class="w-full h-full object-contain">
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="font-bold text-neutral-800">SeaBank</div>
                                <div class="text-xs text-neutral-500 font-mono">901229078240</div>
                            </div>
                        </div>
                    </label>
                </div>

                <p id="error-payment" class="hidden text-sm text-red-500 mt-2">
                    ⚠️ Silakan pilih metode pembayaran terlebih dahulu
                </p>
            </div>

            {{-- ===== TOTAL DENGAN ONGKIR ===== --}}
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-5 border border-green-200 space-y-2">
                <div class="flex justify-between items-center text-sm">
                    <span class="text-neutral-600">Jumlah Item:</span>
                    <span id="total-item" class="font-semibold text-neutral-800">0 item</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-neutral-600">Subtotal Produk:</span>
                    <span id="subtotal-harga" class="font-semibold text-neutral-800">Rp0</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-1.5">
                        <span class="text-neutral-600">Biaya Pengiriman (Ongkir):</span>
                        <span id="label-ongkir-terpilih" class="text-xs px-2 py-0.5 bg-green-100 text-green-800 rounded font-medium">Ambil di Toko</span>
                    </div>
                    <span id="ongkir-harga" class="font-semibold text-neutral-800">Rp0</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-green-200">
                    <div>
                        <span class="text-base font-bold text-neutral-900 block">Total Pembayaran</span>
                        <span class="text-xs text-neutral-500">Sudah termasuk produk & ongkir</span>
                    </div>
                    <span id="total-harga" class="text-2xl font-extrabold text-green-700">Rp0</span>
                </div>
            </div>

            {{-- ===== TOMBOL ===== --}}
            <div class="flex gap-3">
                <a href="{{ url('/') }}"
                   class="flex-1 text-center px-4 py-3 border border-neutral-200 hover:border-neutral-300 text-neutral-700 font-semibold rounded-xl transition">
                    Batal
                </a>
                <button type="submit" id="btn-konfirmasi"
                        class="flex-1 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition shadow-lg shadow-green-600/20 flex items-center justify-center gap-2">
                    <span>✓</span> Lanjut ke Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
const STORE_LAT = parseFloat('{{ config('simantap.store_latitude') }}');
const STORE_LNG = parseFloat('{{ config('simantap.store_longitude') }}');

let mapToko = null;
let markerToko = null;

let mapPelanggan = null;
let markerPelanggan = null;

document.addEventListener('DOMContentLoaded', () => {
    renderProdukDiForm();
    handleShippingChange();
    initMapToko();
    initMapPelanggan();
    document.getElementById('form-pemesanan').addEventListener('submit', handleSubmit);
    
    // Event Listener untuk update ongkir otomatis
    document.getElementById('berat_barang')?.addEventListener('input', hitungOngkirOtomatis);
    document.getElementById('alamat')?.addEventListener('input', hitungOngkirOtomatis);
});

function rupiah(n) {
    return 'Rp' + Number(n).toLocaleString('id-ID');
}

let cachedSubtotal = 0;
let cachedTotalItem = 0;

function renderProdukDiForm() {
    const cart = JSON.parse(localStorage.getItem('simantap_cart') || '[]');
    const container = document.getElementById('daftar-produk');
    const empty = document.getElementById('produk-kosong');
    const btnKonfirmasi = document.getElementById('btn-konfirmasi');

    if (cart.length === 0) {
        container.innerHTML = '';
        empty.classList.remove('hidden');
        btnKonfirmasi.disabled = true;
        btnKonfirmasi.classList.add('opacity-50', 'cursor-not-allowed');
        cachedSubtotal = 0;
        cachedTotalItem = 0;
        hitungOngkirOtomatis();
        return;
    }

    empty.classList.add('hidden');
    btnKonfirmasi.disabled = false;
    btnKonfirmasi.classList.remove('opacity-50', 'cursor-not-allowed');

    container.innerHTML = cart.map(item => {
        const subtotal = item.harga * item.qty;
        return `
            <div class="flex gap-3 bg-neutral-50 rounded-xl p-3 items-center">
                <img src="${item.gambar || 'https://images.unsplash.com/photo-1592417817098-8f3d6ef2393c?w=150'}" alt="${item.nama || item.nama_produk || 'Produk'}"
                     class="w-16 h-16 object-cover rounded-lg shrink-0">
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-sm text-neutral-900 truncate">${item.nama || item.nama_produk || 'Produk'}</h4>
                    <p class="text-xs text-neutral-500 mt-0.5">${rupiah(item.harga)}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="ubahQtyForm(${item.id}, -1)"
                            class="w-7 h-7 rounded-md bg-white border border-neutral-200 hover:border-green-600 hover:text-green-600 font-bold text-sm">−</button>
                    <span class="text-sm font-semibold w-6 text-center">${item.qty}</span>
                    <button type="button" onclick="ubahQtyForm(${item.id}, 1)"
                            class="w-7 h-7 rounded-md bg-white border border-neutral-200 hover:border-green-600 hover:text-green-600 font-bold text-sm">+</button>
                </div>
                <div class="text-sm font-bold text-green-600 w-24 text-right">
                    ${rupiah(subtotal)}
                </div>
            </div>
        `;
    }).join('');

    cachedSubtotal = cart.reduce((sum, i) => sum + (i.harga * i.qty), 0);
    cachedTotalItem = cart.reduce((sum, i) => sum + i.qty, 0);
    hitungOngkirOtomatis();
}

// Inisialisasi Peta Lokasi & Titik Koordinat Toko SIMANTAP
function initMapToko() {
    const tokoContainer = document.getElementById('map-toko');
    if (!tokoContainer) return;

    mapToko = L.map('map-toko', {
        scrollWheelZoom: false
    }).setView([STORE_LAT, STORE_LNG], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(mapToko);

    // Marker Toko
    markerToko = L.marker([STORE_LAT, STORE_LNG]).addTo(mapToko);
    markerToko.bindPopup(`
        <div style="font-size: 13px; line-height: 1.4;">
            <b style="color: #15803d; font-size: 14px;">🏪 Toko {{ config('simantap.store_name') }}</b><br>
            {{ config('simantap.store_address') }}<br>
            <span style="color: #047857; font-family: monospace; font-size: 11px;">📍 ${STORE_LAT}, ${STORE_LNG}</span>
        </div>
    `).openPopup();
}

// Inisialisasi Peta Titik Koordinat Pelanggan (Pin Marker Pengantaran)
function initMapPelanggan() {
    const custContainer = document.getElementById('map-pelanggan');
    if (!custContainer) return;

    const latInput = document.getElementById('pelanggan-lat');
    const lngInput = document.getElementById('pelanggan-lng');

    let initialLat = latInput.value ? parseFloat(latInput.value) : STORE_LAT;
    let initialLng = lngInput.value ? parseFloat(lngInput.value) : STORE_LNG;

    mapPelanggan = L.map('map-pelanggan', {
        scrollWheelZoom: false
    }).setView([initialLat, initialLng], 14);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(mapPelanggan);

    markerPelanggan = L.marker([initialLat, initialLng], { draggable: true }).addTo(mapPelanggan);
    markerPelanggan.bindPopup('<b>📍 Lokasi Pengantaran Anda</b><br>Geser ke lokasi rumah/lahan').openPopup();

    markerPelanggan.on('dragend', function () {
        const pos = markerPelanggan.getLatLng();
        latInput.value = pos.lat.toFixed(6);
        lngInput.value = pos.lng.toFixed(6);
        hitungOngkirOtomatis(); // Hitung ulang ongkir saat marker digeser
    });

    mapPelanggan.on('click', function (e) {
        markerPelanggan.setLatLng(e.latlng);
        latInput.value = e.latlng.lat.toFixed(6);
        lngInput.value = e.latlng.lng.toFixed(6);
        hitungOngkirOtomatis(); // Hitung ulang ongkir saat peta diklik
    });

    [latInput, lngInput].forEach(inp => {
        inp.addEventListener('change', () => {
            const lat = parseFloat(latInput.value);
            const lng = parseFloat(lngInput.value);
            if (!isNaN(lat) && !isNaN(lng) && mapPelanggan && markerPelanggan) {
                mapPelanggan.setView([lat, lng], 15);
                markerPelanggan.setLatLng([lat, lng]);
                hitungOngkirOtomatis();
            }
        });
    });
}

// Deteksi Lokasi Pelanggan (GPS Browser)
function deteksiLokasiPelanggan() {
    if (!navigator.geolocation) {
        alert('Browser Anda tidak mendukung deteksi lokasi (Geolocation).');
        return;
    }

    const icon = document.getElementById('gps-icon');
    const label = document.getElementById('gps-label');
    const oldLabel = label.textContent;

    icon.textContent = '⏳';
    label.textContent = 'Mendeteksi...';

    navigator.geolocation.getCurrentPosition(
        function (pos) {
            const lat = pos.coords.latitude.toFixed(6);
            const lng = pos.coords.longitude.toFixed(6);

            document.getElementById('pelanggan-lat').value = lat;
            document.getElementById('pelanggan-lng').value = lng;

            if (mapPelanggan && markerPelanggan) {
                mapPelanggan.setView([lat, lng], 16);
                markerPelanggan.setLatLng([lat, lng]).bindPopup('<b>📍 Lokasi GPS Anda</b>').openPopup();
            }

            hitungOngkirOtomatis(); // Update ongkir setelah GPS didapat

            icon.textContent = '✓';
            label.textContent = 'Lokasi Terdeteksi';
            setTimeout(() => {
                icon.textContent = '🎯';
                label.textContent = oldLabel;
            }, 3000);
        },
        function (err) {
            icon.textContent = '⚠️';
            label.textContent = 'Gagal Deteksi';
            alert('Tidak dapat mengambil lokasi GPS: ' + err.message);
            setTimeout(() => {
                icon.textContent = '🎯';
                label.textContent = oldLabel;
            }, 2000);
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
}

// Salin Koordinat Toko ke Clipboard
function salinKoordinatToko() {
    const coords = `${STORE_LAT}, ${STORE_LNG}`;
    navigator.clipboard.writeText(coords).then(() => {
        const textEl = document.getElementById('copy-toko-text');
        const iconEl = document.getElementById('copy-toko-icon');
        textEl.textContent = 'Tersalin!';
        iconEl.textContent = '✓';
        setTimeout(() => {
            textEl.textContent = 'Salin';
            iconEl.textContent = '📋';
        }, 2500);
    }).catch(() => {
        prompt('Salin titik koordinat toko berikut:', coords);
    });
}

function handleShippingChange() {
    const radios = document.querySelectorAll('input[name="shipping_method"]');
    let selectedRadio = null;

    radios.forEach(r => {
        const card = r.nextElementSibling;
        if (r.checked) {
            selectedRadio = r;
            card.classList.add('border-green-600', 'bg-green-50/60');
            card.classList.remove('border-neutral-200');
        } else {
            card.classList.remove('border-green-600', 'bg-green-50/60');
            card.classList.add('border-neutral-200');
        }
    });

    if (!selectedRadio) return;

    const val = selectedRadio.value;
    const badge = document.getElementById('notif-status-badge');
    const desc = document.getElementById('notif-status-desc');
    const kotakToko = document.getElementById('kotak-toko-section');
    const inputBerat = document.getElementById('input-berat-container');
    const teksToko = document.getElementById('teks-keterangan-toko');

    // Tampilkan/Sembunyikan input berat
    if (val === 'jnt_cargo') {
        inputBerat.classList.remove('hidden');
    } else {
        inputBerat.classList.add('hidden');
    }

    // Logika Keterangan Notifikasi
    if (val === 'pickup') {
        badge.textContent = 'Keterangan: Barang Diproses & Siap Diambil di Toko';
        desc.innerHTML = 'Setelah pembayaran diverifikasi, pesanan Anda akan <strong>diproses & disiapkan</strong> di toko. Anda dapat mengambilnya langsung di toko SIMANTAP.';
        if (teksToko) teksToko.innerHTML = 'Anda memilih <strong>Ambil Sendiri di Toko</strong>. Silakan kunjungi lokasi titik koordinat toko pada peta di bawah saat pesanan Anda sudah siap diambil.';
    } else if (val === 'kurir_toko') {
        badge.textContent = 'Keterangan: Barang Diproses & Diantar oleh Kurir Toko 🛵';
        desc.innerHTML = 'Pesanan Anda akan <strong>diproses & disiapkan</strong> terlebih dahulu, kemudian <strong>diantar langsung</strong> ke alamat tujuan oleh kurir resmi SIMANTAP.';
    } else if (val === 'jnt_reguler') {
        badge.textContent = 'Keterangan: Barang Diproses & Diantar via J&T Reguler 📦';
        desc.innerHTML = 'Pesanan Anda akan dipacking aman dan diantar ke alamat melalui ekspedisi J&T Express (Reguler).';
    } else if (val === 'jnt_cargo') {
        badge.textContent = 'Keterangan: Barang Diproses & Diantar via J&T Cargo 🚛';
        desc.innerHTML = 'Pesanan Anda akan dipacking aman dan diantar ke alamat melalui layanan J&T Cargo (Minimal 10 Kg).';
    }

    hitungOngkirOtomatis();
}

// Fungsi Hitung Ongkir Otomatis (Haversine untuk J&T)
function hitungOngkirOtomatis() {
    const selectedRadio = document.querySelector('input[name="shipping_method"]:checked');
    if (!selectedRadio) return;

    let ongkir = Number(selectedRadio.dataset.cost || 0);
    const method = selectedRadio.value;

    // Ambil koordinat pelanggan dari input form
    const lat = parseFloat(document.getElementById('pelanggan-lat').value);
    const lng = parseFloat(document.getElementById('pelanggan-lng').value);

    // Jika pelanggan belum set koordinat, pakai jarak 0 (anggap ambil di toko)
    const jarakKm = (!isNaN(lat) && !isNaN(lng)) ? hitungJarak(STORE_LAT, STORE_LNG, lat, lng) : 0;

    if (method === 'jnt_reguler') {
        // Simulasi Tarif J&T Reguler berdasarkan jarak
        if (jarakKm <= 15) ongkir = 10000;
        else if (jarakKm <= 50) ongkir = 20000;
        else ongkir = 35000;
        
        document.getElementById('harga-jnt-reguler').textContent = rupiah(ongkir);
    } 
    else if (method === 'jnt_cargo') {
        // Simulasi Tarif J&T Cargo berdasarkan Berat (Min 10kg)
        const berat = parseFloat(document.getElementById('berat_barang').value) || 10;
        const beratTagihan = Math.max(10, berat);
        
        // Tarif Default Rp 6.500 / kg (bisa disesuaikan dengan string alamat)
        let tarifPerKg = 6500; 
        const alamat = document.getElementById('alamat').value.toLowerCase();
        
        if (alamat.includes('surabaya')) tarifPerKg = 6500;
        else if (alamat.includes('jakarta')) tarifPerKg = 4500;
        else if (alamat.includes('jombang')) tarifPerKg = 3000;
        
        ongkir = beratTagihan * tarifPerKg;
        document.getElementById('harga-jnt-cargo').textContent = rupiah(ongkir);
    }

    // Update total tampilan
    const label = selectedRadio.dataset.label;
    document.getElementById('total-item').textContent = cachedTotalItem + ' item';
    document.getElementById('subtotal-harga').textContent = rupiah(cachedSubtotal);
    document.getElementById('ongkir-harga').textContent = rupiah(ongkir);
    document.getElementById('label-ongkir-terpilih').textContent = label;
    document.getElementById('total-harga').textContent = rupiah(cachedSubtotal + ongkir);
}

// Fungsi Haversine (Jarak Km)
function hitungJarak(lat1, lon1, lat2, lon2) {
    var R = 6371; // Radius bumi dalam km
    var dLat = (lat2 - lat1) * Math.PI / 180;
    var dLon = (lon2 - lon1) * Math.PI / 180;
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function ubahQtyForm(id, delta) {
    let cart = JSON.parse(localStorage.getItem('simantap_cart') || '[]');
    const item = cart.find(i => i.id === id);
    if (!item) return;

    item.qty += delta;
    if (item.qty <= 0) {
        cart = cart.filter(i => i.id !== id);
    }
    localStorage.setItem('simantap_cart', JSON.stringify(cart));
    renderProdukDiForm();
}

function handleSubmit(e) {
    e.preventDefault();

    const cart = JSON.parse(localStorage.getItem('simantap_cart') || '[]');
    if (cart.length === 0) {
        alert('Keranjang masih kosong');
        return;
    }

    const nama = document.getElementById('nama').value.trim();
    const hp = document.getElementById('hp').value.trim();
    const alamat = document.getElementById('alamat').value.trim();

    if (!nama || !hp || !alamat) {
        alert('Mohon lengkapi semua data pelanggan yang wajib diisi');
        return;
    }

    // Cek metode pembayaran
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    const errorPayment = document.getElementById('error-payment');

    if (!paymentMethod) {
        errorPayment.classList.remove('hidden');
        document.querySelector('.payment-option').scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }
    errorPayment.classList.add('hidden');

    // Pengiriman
    const selectedShipping = document.querySelector('input[name="shipping_method"]:checked');
    const shippingMethod = selectedShipping ? selectedShipping.value : 'pickup';
    const shippingLabel = selectedShipping ? selectedShipping.dataset.label : 'Ambil Sendiri di Toko';
    const shippingType = selectedShipping ? selectedShipping.dataset.type : 'Ambil di Toko';
    
    // Ambil ongkir dari tampilan terakhir (sudah dihitung JS)
    const ongkirStr = document.getElementById('ongkir-harga').textContent.replace(/[^0-9]/g, '');
    const ongkir = parseInt(ongkirStr) || 0;

    const beratBarang = document.getElementById('berat_barang')?.value || 0;

    const subtotal = cart.reduce((sum, i) => sum + (i.harga * i.qty), 0);
    const total = subtotal + ongkir;

    // Status keterangan barang
    let statusKeterangan = '';
    if (shippingMethod === 'pickup') {
        statusKeterangan = 'Barang Sedang Diproses & Siap Diambil di Toko';
    } else {
        statusKeterangan = 'Barang Sedang Diproses & Siap Diantar ke Alamat Anda';
    }

    // Titik koordinat pelanggan
    const pelangganLat = document.getElementById('pelanggan-lat')?.value.trim() || '';
    const pelangganLng = document.getElementById('pelanggan-lng')?.value.trim() || '';

    // Simpan data pesanan
    const orderData = {
        nomor: 'ORD-' + new Date().toISOString().slice(0, 10).replace(/-/g, '') + '-' + String(Math.floor(Math.random() * 9999) + 1).padStart(4, '0'),
        nama: nama,
        hp: hp,
        alamat: alamat,
        latitude: pelangganLat,
        longitude: pelangganLng,
        store_latitude: '{{ config('simantap.store_latitude') }}',
        store_longitude: '{{ config('simantap.store_longitude') }}',
        store_address: '{{ config('simantap.store_address') }}',
        catatan: document.getElementById('catatan').value.trim(),
        payment_method: paymentMethod.value,
        shipping_method: shippingMethod,
        shipping_label: shippingLabel,
        shipping_type: shippingType,
        berat_barang: beratBarang,
        ongkir: ongkir,
        subtotal: subtotal,
        total: total,
        status: 'diproses',
        keterangan_status: statusKeterangan,
        is_diantar: shippingMethod !== 'pickup',
        produk: cart,
        created_at: new Date().toISOString()
    };

    localStorage.setItem('simantap_last_order', JSON.stringify(orderData));

    // Redirect ke halaman pembayaran
    window.location.href = "{{ url('/orders/payment') }}";
}
</script>
@endpush