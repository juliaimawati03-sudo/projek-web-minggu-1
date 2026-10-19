@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Pengguna')
@section('page-desc', 'Kelola akun admin, kasir, dan pelanggan beserta titik koordinat peta')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .leaflet-container {
        z-index: 1;
        font-family: inherit;
    }
    .badge-pelanggan {
        background-color: #10b981;
        color: white;
    }
</style>
@endpush

@section('content')

    {{-- Notifikasi Sukses / Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-1"></i> Terjadi kesalahan validasi:
            <ul class="mb-0 mt-1 pl-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-users mr-1"></i> Daftar Pengguna Sistem
                </h6>
                <small class="text-muted">Kelola akun Admin, Kasir, dan Pelanggan dengan titik koordinat maps</small>
            </div>
            <button class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#modalTambahPengguna">
                <i class="fas fa-user-plus mr-1"></i> Tambah Pengguna
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Kontak & Alamat</th>
                            <th>Titik Koordinat (Pin Marker)</th>
                            <th>Role</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengguna as $u)
                        <tr>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle {{ $u->role === 'admin' ? 'bg-primary' : ($u->role === 'kasir' ? 'bg-secondary' : 'bg-success') }} text-white d-flex align-items-center justify-content-center mr-2 font-weight-bold shadow-sm"
                                         style="width: 34px; height: 34px; font-size: 14px;">
                                        {{ strtoupper(substr($u->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-weight-bold text-dark d-block">{{ $u->nama }}</span>
                                        <small class="text-muted">ID: #{{ $u->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <code>{{ $u->username }}</code>
                            </td>
                            <td class="align-middle">
                                <div class="small">
                                    @if($u->no_hp)
                                        <div class="text-dark font-weight-bold mb-1">
                                            <i class="fas fa-phone-alt text-success mr-1"></i> {{ $u->no_hp }}
                                        </div>
                                    @endif
                                    @if($u->alamat)
                                        <div class="text-muted text-truncate" style="max-width: 220px;" title="{{ $u->alamat }}">
                                            <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $u->alamat }}
                                        </div>
                                    @endif
                                    @if(!$u->no_hp && !$u->alamat)
                                        <span class="text-muted font-italic">- Belum diisi -</span>
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle">
                                @if($u->latitude && $u->longitude)
                                    <div>
                                        <span class="badge badge-light border text-dark font-weight-bold p-1 d-inline-block mb-1" style="font-size: 11px;">
                                            <i class="fas fa-map-pin text-danger mr-1"></i> {{ round($u->latitude, 5) }}, {{ round($u->longitude, 5) }}
                                        </span>
                                        <div>
                                            <a href="https://www.google.com/maps?q={{ $u->latitude }},{{ $u->longitude }}" target="_blank"
                                               class="btn btn-xs btn-outline-primary py-0 px-2" style="font-size: 11px;">
                                                <i class="fas fa-external-link-alt mr-1"></i> Buka Maps
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge badge-light text-muted border font-weight-normal py-1 px-2" style="font-size: 11px;">
                                        <i class="fas fa-map-marker-slash text-gray-400 mr-1"></i> Belum ada pin
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($u->role === 'admin')
                                    <span class="badge badge-primary px-2 py-1">
                                        <i class="fas fa-shield-alt mr-1"></i> Admin
                                    </span>
                                @elseif($u->role === 'kasir')
                                    <span class="badge badge-secondary px-2 py-1">
                                        <i class="fas fa-cash-register mr-1"></i> Kasir
                                    </span>
                                @else
                                    <span class="badge badge-success px-2 py-1">
                                        <i class="fas fa-user-tag mr-1"></i> Pelanggan
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <button class="btn btn-sm btn-warning mb-1"
                                        onclick="editPengguna({{ $u->id }}, '{{ addslashes($u->nama) }}', '{{ addslashes($u->username) }}', '{{ $u->role }}', '{{ addslashes($u->no_hp ?? '') }}', '{{ addslashes(str_replace(["\r", "\n"], ' ', $u->alamat ?? '')) }}', '{{ $u->latitude ?? '' }}', '{{ $u->longitude ?? '' }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <form action="{{ route('admin.pengguna.destroy', $u->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus pengguna {{ addslashes($u->nama) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mb-1" title="Hapus Pengguna">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-2x text-gray-300 mb-2 d-block"></i>
                                Belum ada data pengguna.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Pengguna --}}
    <div class="modal fade" id="modalTambahPengguna" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.pengguna.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title font-weight-bold" id="modalTambahLabel">
                            <i class="fas fa-user-plus mr-1"></i> Tambah Pengguna Baru
                        </h5>
                        <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" required placeholder="Contoh: Budi Santoso">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" required placeholder="Contoh: budi_santoso">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required minlength="6" placeholder="Minimal 6 karakter">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Role Pengguna <span class="text-danger">*</span></label>
                                <select name="role" id="tambahRole" class="form-control" required>
                                    <option value="pelanggan" selected>Pelanggan</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nomor WhatsApp / HP</label>
                                <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 081234567890">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Alamat Lengkap</label>
                                <input type="text" name="alamat" class="form-control" placeholder="Contoh: Jl. Pertanian No. 12, RT 01/RW 02">
                            </div>
                        </div>

                        {{-- Titik Koordinat (Pin Marker) --}}
                        <div class="card border-left-success bg-light mb-2">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                                    <label class="font-weight-bold text-success mb-0">
                                        <i class="fas fa-map-marked-alt mr-1"></i> Titik Koordinat Pelanggan (Pin Marker)
                                    </label>
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="gunakanLokasiSaatIni('tambah')">
                                        <i class="fas fa-crosshairs mr-1"></i> Gunakan Lokasi Saat Ini (GPS)
                                    </button>
                                </div>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-info-circle text-info mr-1"></i> Geser <strong>Pin Marker</strong> atau klik langsung pada peta di bawah ini untuk menentukan titik koordinat pelanggan secara akurat.
                                </p>

                                <div class="row mb-2">
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="small font-weight-bold text-muted">Latitude</label>
                                        <input type="text" id="tambahLat" name="latitude" class="form-control form-control-sm font-weight-bold text-monospace" placeholder="-7.546835">
                                    </div>
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="small font-weight-bold text-muted">Longitude</label>
                                        <input type="text" id="tambahLng" name="longitude" class="form-control form-control-sm font-weight-bold text-monospace" placeholder="112.226512">
                                    </div>
                                </div>

                                {{-- Container Map --}}
                                <div id="mapTambah" style="height: 250px; width: 100%; border-radius: 8px; border: 1px solid #d1d5db;" class="shadow-sm"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Pengguna --}}
    <div class="modal fade" id="modalEditPengguna" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="formEditPengguna" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title font-weight-bold" id="modalEditLabel">
                            <i class="fas fa-user-edit mr-1"></i> Edit Data Pengguna
                        </h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" id="editNama" name="nama" class="form-control" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Username <span class="text-danger">*</span></label>
                                <input type="text" id="editUsername" name="username" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                                <input type="password" name="password" class="form-control" minlength="6" placeholder="••••••••">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Role <span class="text-danger">*</span></label>
                                <select id="editRole" name="role" class="form-control" required>
                                    <option value="pelanggan">Pelanggan</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nomor WhatsApp / HP</label>
                                <input type="text" id="editNoHp" name="no_hp" class="form-control" placeholder="Contoh: 081234567890">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Alamat Lengkap</label>
                                <input type="text" id="editAlamat" name="alamat" class="form-control" placeholder="Contoh: Jl. Pertanian No. 12">
                            </div>
                        </div>

                        {{-- Titik Koordinat (Pin Marker) Edit --}}
                        <div class="card border-left-warning bg-light mb-2">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
                                    <label class="font-weight-bold text-dark mb-0">
                                        <i class="fas fa-map-marked-alt text-warning mr-1"></i> Titik Koordinat Pelanggan (Pin Marker)
                                    </label>
                                    <button type="button" class="btn btn-sm btn-outline-warning" onclick="gunakanLokasiSaatIni('edit')">
                                        <i class="fas fa-crosshairs mr-1"></i> Gunakan Lokasi Saat Ini (GPS)
                                    </button>
                                </div>
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-info-circle text-info mr-1"></i> Geser <strong>Pin Marker</strong> atau klik peta untuk memperbarui titik koordinat pengguna/pelanggan.
                                </p>

                                <div class="row mb-2">
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="small font-weight-bold text-muted">Latitude</label>
                                        <input type="text" id="editLat" name="latitude" class="form-control form-control-sm font-weight-bold text-monospace" placeholder="-7.546835">
                                    </div>
                                    <div class="col-md-6 form-group mb-2">
                                        <label class="small font-weight-bold text-muted">Longitude</label>
                                        <input type="text" id="editLng" name="longitude" class="form-control form-control-sm font-weight-bold text-monospace" placeholder="112.226512">
                                    </div>
                                </div>

                                {{-- Container Map Edit --}}
                                <div id="mapEdit" style="height: 250px; width: 100%; border-radius: 8px; border: 1px solid #d1d5db;" class="shadow-sm"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Perbarui Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
const DEFAULT_LAT = parseFloat('{{ config('simantap.store_latitude') }}');
const DEFAULT_LNG = parseFloat('{{ config('simantap.store_longitude') }}');

let mapTambah = null;
let markerTambah = null;
let mapEdit = null;
let markerEdit = null;

// Modal Tambah Pengguna Shown
$('#modalTambahPengguna').on('shown.bs.modal', function () {
    const latInput = document.getElementById('tambahLat').value;
    const lngInput = document.getElementById('tambahLng').value;

    const latVal = latInput ? parseFloat(latInput) : DEFAULT_LAT;
    const lngVal = lngInput ? parseFloat(lngInput) : DEFAULT_LNG;

    if (!mapTambah) {
        mapTambah = L.map('mapTambah').setView([latVal, lngVal], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(mapTambah);

        markerTambah = L.marker([latVal, lngVal], { draggable: true }).addTo(mapTambah);
        markerTambah.bindPopup('<b>📍 Pin Marker Pelanggan</b><br>Geser ke lokasi pelanggan').openPopup();

        markerTambah.on('dragend', function () {
            const pos = markerTambah.getLatLng();
            document.getElementById('tambahLat').value = pos.lat.toFixed(6);
            document.getElementById('tambahLng').value = pos.lng.toFixed(6);
        });

        mapTambah.on('click', function (e) {
            markerTambah.setLatLng(e.latlng);
            document.getElementById('tambahLat').value = e.latlng.lat.toFixed(6);
            document.getElementById('tambahLng').value = e.latlng.lng.toFixed(6);
        });
    } else {
        mapTambah.invalidateSize();
        mapTambah.setView([latVal, lngVal], 13);
        markerTambah.setLatLng([latVal, lngVal]);
    }

    if (!latInput) {
        document.getElementById('tambahLat').value = latVal.toFixed(6);
        document.getElementById('tambahLng').value = lngVal.toFixed(6);
    }
});

// Modal Edit Pengguna Shown
$('#modalEditPengguna').on('shown.bs.modal', function () {
    const latInput = document.getElementById('editLat').value;
    const lngInput = document.getElementById('editLng').value;

    const latVal = latInput ? parseFloat(latInput) : DEFAULT_LAT;
    const lngVal = lngInput ? parseFloat(lngInput) : DEFAULT_LNG;

    if (!mapEdit) {
        mapEdit = L.map('mapEdit').setView([latVal, lngVal], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(mapEdit);

        markerEdit = L.marker([latVal, lngVal], { draggable: true }).addTo(mapEdit);
        markerEdit.bindPopup('<b>📍 Pin Marker Pelanggan</b><br>Geser ke lokasi pelanggan');

        markerEdit.on('dragend', function () {
            const pos = markerEdit.getLatLng();
            document.getElementById('editLat').value = pos.lat.toFixed(6);
            document.getElementById('editLng').value = pos.lng.toFixed(6);
        });

        mapEdit.on('click', function (e) {
            markerEdit.setLatLng(e.latlng);
            document.getElementById('editLat').value = e.latlng.lat.toFixed(6);
            document.getElementById('editLng').value = e.latlng.lng.toFixed(6);
        });
    } else {
        mapEdit.invalidateSize();
        mapEdit.setView([latVal, lngVal], 13);
        markerEdit.setLatLng([latVal, lngVal]);
    }
});

// Buka Modal Edit
function editPengguna(id, nama, username, role, no_hp, alamat, lat, lng) {
    document.getElementById('formEditPengguna').action = '/admin/pengguna/' + id;
    document.getElementById('editNama').value = nama;
    document.getElementById('editUsername').value = username;
    document.getElementById('editRole').value = role;
    document.getElementById('editNoHp').value = no_hp || '';
    document.getElementById('editAlamat').value = alamat || '';
    document.getElementById('editLat').value = lat || '';
    document.getElementById('editLng').value = lng || '';

    $('#modalEditPengguna').modal('show');
}

// Gunakan Lokasi Saat Ini (GPS Browser)
function gunakanLokasiSaatIni(mode) {
    if (!navigator.geolocation) {
        alert('Geolocation tidak didukung oleh browser Anda.');
        return;
    }

    const btn = event.currentTarget;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Mendeteksi...';
    btn.disabled = true;

    navigator.geolocation.getCurrentPosition(
        function (pos) {
            const lat = pos.coords.latitude.toFixed(6);
            const lng = pos.coords.longitude.toFixed(6);
            btn.innerHTML = originalText;
            btn.disabled = false;

            if (mode === 'tambah') {
                document.getElementById('tambahLat').value = lat;
                document.getElementById('tambahLng').value = lng;
                if (mapTambah && markerTambah) {
                    mapTambah.setView([lat, lng], 15);
                    markerTambah.setLatLng([lat, lng]).bindPopup('<b>📍 Lokasi Anda Terdeteksi</b>').openPopup();
                }
            } else {
                document.getElementById('editLat').value = lat;
                document.getElementById('editLng').value = lng;
                if (mapEdit && markerEdit) {
                    mapEdit.setView([lat, lng], 15);
                    markerEdit.setLatLng([lat, lng]).bindPopup('<b>📍 Lokasi Anda Terdeteksi</b>').openPopup();
                }
            }
        },
        function (err) {
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Gagal mendeteksi lokasi: ' + err.message);
        },
        { enableHighAccuracy: true, timeout: 10000 }
    );
}

// Sinkronisasi input teks koordinat ke marker
document.addEventListener('DOMContentLoaded', function () {
    ['tambahLat', 'tambahLng'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', function () {
            const lat = parseFloat(document.getElementById('tambahLat').value);
            const lng = parseFloat(document.getElementById('tambahLng').value);
            if (!isNaN(lat) && !isNaN(lng) && mapTambah && markerTambah) {
                mapTambah.setView([lat, lng], 14);
                markerTambah.setLatLng([lat, lng]);
            }
        });
    });

    ['editLat', 'editLng'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', function () {
            const lat = parseFloat(document.getElementById('editLat').value);
            const lng = parseFloat(document.getElementById('editLng').value);
            if (!isNaN(lat) && !isNaN(lng) && mapEdit && markerEdit) {
                mapEdit.setView([lat, lng], 14);
                markerEdit.setLatLng([lat, lng]);
            }
        });
    });
});
</script>
@endpush