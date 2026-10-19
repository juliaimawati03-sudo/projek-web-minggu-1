<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun Pelanggan - SIMANTAP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg my-8">

        {{-- Logo --}}
        <div class="text-center mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 mb-2 group">
                <div class="w-14 h-14 bg-green-600 rounded-2xl flex items-center justify-center text-white text-3xl shadow-lg group-hover:scale-105 transition">
                    🌾
                </div>
                <span class="text-3xl font-extrabold text-green-700">SIMANTAP</span>
            </a>
            <p class="text-sm text-neutral-500">Pendaftaran Akun Pelanggan Toko Alat Pertanian</p>
        </div>

        {{-- Card Register --}}
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <div class="text-center mb-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold mb-2">
                    🛍️ Khusus Pelanggan
                </div>
                <h1 class="text-2xl font-bold text-neutral-900 mb-1">Buat Akun Pelanggan</h1>
                <p class="text-sm text-neutral-500">Daftar sekarang untuk kemudahan pemesanan & lacak status pengantaran barang</p>
            </div>

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm space-y-1">
                    <div class="font-bold flex items-center gap-1">
                        <span>⚠️</span> Mohon periksa kesalahan berikut:
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Register --}}
            <form method="POST" action="{{ route('register.attempt') }}" class="space-y-4">
                @csrf

                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama" class="block text-sm font-medium text-neutral-700 mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">👤</span>
                        <input type="text" id="nama" name="nama"
                               value="{{ old('nama') }}"
                               required autofocus
                               placeholder="Contoh: Budi Santoso"
                               class="w-full pl-11 pr-4 py-2.5 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm">
                    </div>
                </div>

                {{-- Username & No HP --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-neutral-700 mb-1">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">@</span>
                            <input type="text" id="username" name="username"
                                   value="{{ old('username') }}"
                                   required
                                   placeholder="budisantoso"
                                   class="w-full pl-11 pr-4 py-2.5 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-neutral-700 mb-1">
                            Nomor WhatsApp/HP <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">📱</span>
                            <input type="tel" id="no_hp" name="no_hp"
                                   value="{{ old('no_hp') }}"
                                   required
                                   placeholder="081234567890"
                                   class="w-full pl-11 pr-4 py-2.5 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm">
                        </div>
                    </div>
                </div>

                {{-- Alamat Lengkap --}}
                <div>
                    <label for="alamat" class="block text-sm font-medium text-neutral-700 mb-1">
                        Alamat Pengiriman Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <textarea id="alamat" name="alamat" required rows="2"
                                  placeholder="Contoh: Jl. Pertanian No. 12, RT 02/RW 04, Desa Sukamaju, Kec. Subur"
                                  class="w-full px-4 py-2.5 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm resize-none">{{ old('alamat') }}</textarea>
                    </div>
                    <p class="text-xs text-neutral-400 mt-1">Alamat ini digunakan otomatis untuk tujuan pengantaran saat Anda memesan alat pertanian.</p>
                </div>

                {{-- Titik Koordinat Pengiriman (Pin Marker) --}}
                <div class="bg-neutral-50 rounded-xl p-3.5 border border-neutral-200">
                    <div class="flex items-center justify-between flex-wrap gap-2 mb-2">
                        <label class="block text-xs font-bold text-neutral-800">
                            📍 Titik Koordinat Rumah/Lahan <span class="text-neutral-400 font-normal">(opsional)</span>
                        </label>
                        <button type="button" onclick="deteksiLokasiRegister()"
                                class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-lg bg-green-100 text-green-800 hover:bg-green-200 border border-green-300 transition">
                            <span id="reg-gps-icon">🎯</span> <span id="reg-gps-label">Lokasi GPS</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <div>
                            <input type="text" id="reg-lat" name="latitude" value="{{ old('latitude') }}"
                                   placeholder="Latitude (-7.546835)"
                                   class="w-full px-2.5 py-1.5 text-xs font-mono border border-neutral-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-green-500 bg-white">
                        </div>
                        <div>
                            <input type="text" id="reg-lng" name="longitude" value="{{ old('longitude') }}"
                                   placeholder="Longitude (112.226512)"
                                   class="w-full px-2.5 py-1.5 text-xs font-mono border border-neutral-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-green-500 bg-white">
                        </div>
                    </div>

                    <div id="map-register" class="w-full h-36 rounded-lg border border-neutral-300 overflow-hidden relative"></div>
                    <p class="text-[11px] text-neutral-400 mt-1">Geser pin marker merah atau klik peta untuk menentukan titik koordinat rumah Anda.</p>
                </div>

                {{-- Password & Konfirmasi --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-neutral-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">🔒</span>
                            <input type="password" id="password" name="password"
                                   required
                                   placeholder="Minimal 6 karakter"
                                   class="w-full pl-11 pr-4 py-2.5 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 mb-1">
                            Ulangi Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">🔑</span>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   required
                                   placeholder="Ketik ulang password"
                                   class="w-full pl-11 pr-4 py-2.5 border border-neutral-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm">
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full mt-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20 flex items-center justify-center gap-2">
                    <span>✨</span> Daftar Akun Sekarang
                </button>
            </form>

            {{-- Link ke Login --}}
            <div class="mt-6 pt-5 border-t border-neutral-100 text-center">
                <p class="text-sm text-neutral-600">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="font-bold text-green-600 hover:text-green-700 hover:underline">
                        Masuk di sini
                    </a>
                </p>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ url('/') }}" class="text-xs text-neutral-400 hover:text-green-600 transition">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-neutral-400 mt-6">
            © {{ date('Y') }} SIMANTAP. All rights reserved.
        </p>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
    const DEFAULT_LAT = parseFloat('{{ config('simantap.store_latitude') }}');
    const DEFAULT_LNG = parseFloat('{{ config('simantap.store_longitude') }}');

    let mapRegister = null;
    let markerRegister = null;

    document.addEventListener('DOMContentLoaded', () => {
        const latInput = document.getElementById('reg-lat');
        const lngInput = document.getElementById('reg-lng');

        let initialLat = latInput.value ? parseFloat(latInput.value) : DEFAULT_LAT;
        let initialLng = lngInput.value ? parseFloat(lngInput.value) : DEFAULT_LNG;

        mapRegister = L.map('map-register', {
            scrollWheelZoom: false
        }).setView([initialLat, initialLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(mapRegister);

        markerRegister = L.marker([initialLat, initialLng], { draggable: true }).addTo(mapRegister);
        markerRegister.bindPopup('<b>📍 Geser ke lokasi rumah Anda</b>');

        markerRegister.on('dragend', function () {
            const pos = markerRegister.getLatLng();
            latInput.value = pos.lat.toFixed(6);
            lngInput.value = pos.lng.toFixed(6);
        });

        mapRegister.on('click', function (e) {
            markerRegister.setLatLng(e.latlng);
            latInput.value = e.latlng.lat.toFixed(6);
            lngInput.value = e.latlng.lng.toFixed(6);
        });

        [latInput, lngInput].forEach(inp => {
            inp.addEventListener('change', () => {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                if (!isNaN(lat) && !isNaN(lng) && mapRegister && markerRegister) {
                    mapRegister.setView([lat, lng], 14);
                    markerRegister.setLatLng([lat, lng]);
                }
            });
        });
    });

    function deteksiLokasiRegister() {
        if (!navigator.geolocation) {
            alert('Browser tidak mendukung deteksi lokasi.');
            return;
        }

        const icon = document.getElementById('reg-gps-icon');
        const label = document.getElementById('reg-gps-label');
        const oldLabel = label.textContent;

        icon.textContent = '⏳';
        label.textContent = 'Mencari...';

        navigator.geolocation.getCurrentPosition(
            function (pos) {
                const lat = pos.coords.latitude.toFixed(6);
                const lng = pos.coords.longitude.toFixed(6);

                document.getElementById('reg-lat').value = lat;
                document.getElementById('reg-lng').value = lng;

                if (mapRegister && markerRegister) {
                    mapRegister.setView([lat, lng], 15);
                    markerRegister.setLatLng([lat, lng]).bindPopup('<b>📍 Lokasi GPS Terdeteksi</b>').openPopup();
                }

                icon.textContent = '✓';
                label.textContent = 'Terdeteksi';
                setTimeout(() => {
                    icon.textContent = '🎯';
                    label.textContent = oldLabel;
                }, 3000);
            },
            function (err) {
                icon.textContent = '⚠️';
                label.textContent = 'Gagal';
                alert('Gagal mengambil lokasi GPS: ' + err.message);
                setTimeout(() => {
                    icon.textContent = '🎯';
                    label.textContent = oldLabel;
                }, 2000);
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }
    </script>
</body>
</html>
