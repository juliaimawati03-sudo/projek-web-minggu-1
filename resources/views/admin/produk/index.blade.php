@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Produk')
@section('page-desc', 'Kelola data produk alat dan sarana pertanian')

@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahProduk">
                <i class="fas fa-plus mr-1"></i> Tambah Produk
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="80">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Supplier</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $produk = [
                                ['id'=>1,'nama'=>'Cangkul Baja EGA','supplier'=>'CV Tani Makmur','deskripsi'=>'Cangkul baja tahan karat','harga'=>85000,'stok'=>24, 'gambar'=>'https://via.placeholder.com/80x80/22c55e/ffffff?text=Cangkul'],
                                ['id'=>2,'nama'=>'Pupuk NPK Mutiara 1kg','supplier'=>'UD Sumber Subur','deskripsi'=>'Pupuk majemuk semua tanaman','harga'=>35000,'stok'=>6, 'gambar'=>'https://via.placeholder.com/80x80/3b82f6/ffffff?text=Pupuk'],
                                ['id'=>3,'nama'=>'Benih Cabai Hibrida','supplier'=>'Toko Agro Jaya','deskripsi'=>'Benih cabai unggul','harga'=>40000,'stok'=>45, 'gambar'=>'https://via.placeholder.com/80x80/ef4444/ffffff?text=Benih'],
                                ['id'=>4,'nama'=>'Sprayer Elektrik 16L','supplier'=>'CV Tani Makmur','deskripsi'=>'Alat semprot bertenaga baterai','harga'=>320000,'stok'=>3, 'gambar'=>'https://via.placeholder.com/80x80/f59e0b/ffffff?text=Sprayer'],
                            ];
                        @endphp
                        @foreach($produk as $p)
                        <tr>
                            <td>
                                <img src="{{ $p['gambar'] }}"
                                     alt="{{ $p['nama'] }}"
                                     class="rounded"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td class="font-weight-bold">{{ $p['nama'] }}</td>
                            <td>{{ $p['supplier'] }}</td>
                            <td class="text-muted small">{{ $p['deskripsi'] }}</td>
                            <td>Rp {{ number_format($p['harga'], 0, ',', '.') }}</td>
                            <td>
                                @if($p['stok'] < 10)
                                    <span class="badge badge-danger">{{ $p['stok'] }} unit</span>
                                @else
                                    <span class="badge badge-success">{{ $p['stok'] }} unit</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Produk --}}
    <div class="modal fade" id="modalTambahProduk" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form onsubmit="event.preventDefault(); tutupModalTambah();">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Produk</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Nama Produk *</label>
                            <input type="text" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Supplier *</label>
                            <select class="form-control" required>
                                <option value="">— Pilih Supplier —</option>
                                <option>CV Tani Makmur</option>
                                <option>UD Sumber Subur</option>
                                <option>Toko Agro Jaya</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea rows="2" class="form-control"></textarea>
                        </div>

                        {{-- ===== UPLOAD GAMBAR (Frontend Only) ===== --}}
                        <div class="form-group">
                            <label>Gambar Produk</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGambarTambah"
                                       accept="image/*" onchange="previewGambar(this, 'previewTambah')">
                                <label class="custom-file-label" for="inputGambarTambah">Pilih gambar...</label>
                            </div>
                            <small class="text-muted d-block mt-1">Format: JPG, PNG, WEBP. Maks 2 MB.</small>

                            {{-- Preview Gambar --}}
                            <div class="mt-2 text-center">
                                <img id="previewTambah" src="" alt=""
                                     class="rounded d-none border"
                                     style="max-height: 200px; max-width: 100%;">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Harga *</label>
                                <input type="number" class="form-control" required min="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Stok *</label>
                                <input type="number" class="form-control" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
// Preview gambar saat dipilih
function previewGambar(input, previewId) {
    const preview = document.getElementById(previewId);

    if (input.files && input.files[0]) {
        // Validasi ukuran (max 2 MB)
        if (input.files[0].size > 2 * 1024 * 1024) {
            alert('❌ Ukuran gambar terlalu besar. Maksimal 2 MB.');
            input.value = '';
            preview.classList.add('d-none');
            return;
        }

        // Validasi tipe file
        if (!input.files[0].type.startsWith('image/')) {
            alert('❌ File harus berupa gambar (JPG, PNG, WEBP).');
            input.value = '';
            preview.classList.add('d-none');
            return;
        }

        // Baca dan tampilkan gambar
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(input.files[0]);

        // Update label nama file
        const label = input.nextElementSibling;
        if (label) label.textContent = input.files[0].name;
    }
}

// Simulasi simpan (frontend only)
function tutupModalTambah() {
    alert('✅ (Demo) Produk berhasil ditambahkan!\n\nCatatan: Ini hanya simulasi tampilan. Data tidak tersimpan ke database.');
    $('#modalTambahProduk').modal('hide');

    // Reset form
    const form = document.querySelector('#modalTambahProduk form');
    if (form) {
        form.reset();
        document.getElementById('previewTambah').classList.add('d-none');
        document.querySelector('#inputGambarTambah').nextElementSibling.textContent = 'Pilih gambar...';
    }
}
</script>
@endpush