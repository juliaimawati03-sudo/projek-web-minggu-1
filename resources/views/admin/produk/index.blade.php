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
                                ['id'=>1,'nama'=>'Cangkul Baja EGA','supplier'=>'CV Tani Makmur','deskripsi'=>'Cangkul baja tahan karat','harga'=>85000,'stok'=>24],
                                ['id'=>2,'nama'=>'Pupuk NPK Mutiara 1kg','supplier'=>'UD Sumber Subur','deskripsi'=>'Pupuk majemuk semua tanaman','harga'=>35000,'stok'=>6],
                                ['id'=>3,'nama'=>'Benih Cabai Hibrida','supplier'=>'Toko Agro Jaya','deskripsi'=>'Benih cabai unggul','harga'=>40000,'stok'=>45],
                                ['id'=>4,'nama'=>'Sprayer Elektrik 16L','supplier'=>'CV Tani Makmur','deskripsi'=>'Alat semprot bertenaga baterai','harga'=>320000,'stok'=>3],
                            ];
                        @endphp
                        @foreach(($produk ?? []) as $p)
                        <tr>
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
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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
                <form action="{{ route('admin.produk.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Produk</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Produk *</label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Supplier *</label>
                            <select name="supplier_id" class="form-control" required>
                                <option value="1">CV Tani Makmur</option>
                                <option value="2">UD Sumber Subur</option>
                                <option value="3">Toko Agro Jaya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" rows="2" class="form-control"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Harga *</label>
                                <input type="number" name="harga" class="form-control" required min="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Stok *</label>
                                <input type="number" name="stok" class="form-control" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection