@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Produk')
@section('page-desc', 'Kelola data produk alat dan sarana pertanian')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk Alat Pertanian</h6>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahProduk">
                <i class="fas fa-plus mr-1"></i> Tambah Produk
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="70">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Supplier</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $p)
                        <tr>
                            <td class="align-middle text-center">
                                <img src="{{ $p->gambarUrl() }}" alt="{{ $p->nama_produk }}"
                                     class="rounded border" style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td class="align-middle">
                                <div class="font-weight-bold text-dark">{{ $p->nama_produk }}</div>
                                <small class="text-muted text-truncate d-block" style="max-width: 250px;">{{ $p->deskripsi ?? '-' }}</small>
                            </td>
                            <td class="align-middle">
                                @php
                                    $badgeKat = match($p->kategori) {
                                        'pengolahan-tanah' => 'badge-success',
                                        'pemotong' => 'badge-warning',
                                        'ternak' => 'badge-info',
                                        default => 'badge-primary',
                                    };
                                    $labelKat = match($p->kategori) {
                                        'pengolahan-tanah' => 'Olah Tanah',
                                        'pemotong' => 'Pemotong',
                                        'ternak' => 'Ternak',
                                        default => 'Pertanian',
                                    };
                                @endphp
                                <span class="badge {{ $badgeKat }} px-2 py-1">{{ $labelKat }}</span>
                            </td>
                            <td class="align-middle small">{{ $p->supplier->nama_supplier ?? '-' }}</td>
                            <td class="align-middle font-weight-bold text-success">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                            <td class="align-middle">
                                @if($p->stok < 10)
                                    <span class="badge badge-danger">{{ $p->stok }} unit</span>
                                @else
                                    <span class="badge badge-success">{{ $p->stok }} unit</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <button type="button" class="btn btn-sm btn-warning mr-1"
                                        onclick="bukaModalEdit({{ $p->id }}, '{{ addslashes($p->nama_produk) }}', '{{ $p->kategori }}', {{ $p->supplier_id }}, '{{ addslashes($p->deskripsi ?? '') }}', {{ $p->harga }}, {{ $p->stok }})"
                                        title="Edit Produk">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.produk.destroy', $p->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus produk {{ addslashes($p->nama_produk) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Produk">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                Belum ada data produk. Klik tombol <strong>Tambah Produk</strong> untuk menambahkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Produk --}}
    <div class="modal fade" id="modalTambahProduk" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fas fa-plus-circle mr-1"></i> Tambah Produk Baru</h5>
                        <button class="close text-white" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" name="nama_produk" class="form-control" required placeholder="Contoh: Cangkul Baja EGA">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-control" required>
                                    <option value="pertanian">Alat Pertanian</option>
                                    <option value="pengolahan-tanah">Alat Pengolahan Tanah</option>
                                    <option value="pemotong">Alat Pemotong</option>
                                    <option value="ternak">Perlengkapan Ternak</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Supplier <span class="text-danger">*</span></label>
                                <select name="supplier_id" class="form-control" required>
                                    <option value="">— Pilih Supplier —</option>
                                    @foreach($supplier as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Produk</label>
                            <textarea name="deskripsi" rows="2" class="form-control" placeholder="Spesifikasi, keunggulan, bahan produk..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Foto / Gambar Produk</label>
                            <input type="file" name="gambar" class="form-control-file" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, WEBP (maksimal 2 MB)</small>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga" class="form-control" required min="0" placeholder="Contoh: 85000">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Stok Awal <span class="text-danger">*</span></label>
                                <input type="number" name="stok" class="form-control" required min="0" placeholder="Contoh: 25">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit Produk --}}
    <div class="modal fade" id="modalEditProduk" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditProduk" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="fas fa-edit mr-1"></i> Edit Data Produk</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" id="edit_nama_produk" name="nama_produk" class="form-control" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select id="edit_kategori" name="kategori" class="form-control" required>
                                    <option value="pertanian">Alat Pertanian</option>
                                    <option value="pengolahan-tanah">Alat Pengolahan Tanah</option>
                                    <option value="pemotong">Alat Pemotong</option>
                                    <option value="ternak">Perlengkapan Ternak</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Supplier <span class="text-danger">*</span></label>
                                <select id="edit_supplier_id" name="supplier_id" class="form-control" required>
                                    <option value="">— Pilih Supplier —</option>
                                    @foreach($supplier as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Produk</label>
                            <textarea id="edit_deskripsi" name="deskripsi" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Ganti Foto / Gambar Produk (opsional)</label>
                            <input type="file" name="gambar" class="form-control-file" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto produk.</small>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" id="edit_harga" name="harga" class="form-control" required min="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Stok <span class="text-danger">*</span></label>
                                <input type="number" id="edit_stok" name="stok" class="form-control" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning font-weight-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function bukaModalEdit(id, nama, kategori, supplierId, deskripsi, harga, stok) {
    document.getElementById('formEditProduk').action = '/admin/produk/' + id;
    document.getElementById('edit_nama_produk').value = nama;
    document.getElementById('edit_kategori').value = kategori || 'pertanian';
    document.getElementById('edit_supplier_id').value = supplierId;
    document.getElementById('edit_deskripsi').value = deskripsi;
    document.getElementById('edit_harga').value = harga;
    document.getElementById('edit_stok').value = stok;
    $('#modalEditProduk').modal('show');
}
</script>
@endpush