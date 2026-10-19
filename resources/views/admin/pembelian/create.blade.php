@extends('layouts.admin')

@section('title', 'Pembelian Supplier')
@section('page-title', 'Pembelian ke Supplier')
@section('page-desc', 'Catat pembelian barang & stok dari supplier (otomatis tersimpan ke tabel pengeluaran & laporan keuangan)')

@section('content')

    <div class="row">
        {{-- FORM PEMBELIAN --}}
        <div class="col-lg-6 mb-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                <div class="card-header py-3 bg-gradient-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-cart-plus mr-1"></i> Form Catat Pembelian Supplier
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pembelian.store') }}" method="POST">
                        @csrf

                        {{-- DATA SUPPLIER --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-800">Pilih Supplier Terdaftar</label>
                            <select name="supplier_id" id="supplier_select" class="form-control" onchange="toggleSupplierFields()">
                                <option value="">-- Pilih dari Database Supplier --</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}"
                                            data-phone="{{ $s->no_telepon }}"
                                            data-address="{{ $s->alamat }}"
                                            {{ old('supplier_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama_supplier }} ({{ $s->alamat ?? 'Alamat -' }})
                                    </option>
                                @endforeach
                                <option value="manual" {{ old('supplier_id') == 'manual' ? 'selected' : '' }}>
                                    ➕ Tambah Supplier Baru Secara Manual
                                </option>
                            </select>
                            <small class="form-text text-muted">Pilih supplier yang sudah terdaftar di database, atau tambah baru.</small>
                        </div>

                        {{-- MANUAL INPUT JIKA PILIH TAMBAH BARU --}}
                        <div id="manual_supplier_box" style="display: none;" class="p-3 bg-light border rounded mb-3">
                            <h6 class="font-weight-bold text-primary mb-2">
                                <i class="fas fa-plus-circle mr-1"></i> Data Supplier Baru
                            </h6>
                            <div class="form-group">
                                <label>Nama Supplier Baru <span class="text-danger">*</span></label>
                                <input type="text" name="nama_supplier" id="nama_supplier" class="form-control"
                                       placeholder="Contoh: CV Tani Subur Makmur"
                                       value="{{ old('nama_supplier') }}">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telepon" id="no_telepon" class="form-control"
                                           placeholder="08123456789"
                                           value="{{ old('no_telepon') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Alamat</label>
                                    <input type="text" name="alamat" id="alamat" class="form-control"
                                           placeholder="Kota / Alamat"
                                           value="{{ old('alamat') }}">
                                </div>
                            </div>
                        </div>

                        {{-- DETAIL TRANSAKSI PEMBELIAN --}}
                        <div class="form-group">
                            <label class="font-weight-bold text-gray-800">Tanggal Pembelian <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" required
                                   value="{{ old('tanggal', now()->format('Y-m-d')) }}">
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-gray-800">Total Nominal Pembelian (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Rp</span>
                                </div>
                                <input type="number" name="nominal" class="form-control" required
                                       min="1" placeholder="Contoh: 1500000"
                                       value="{{ old('nominal') }}">
                            </div>
                            <small class="form-text text-muted">Nominal akan langsung dicatat ke tabel Pengeluaran & Laporan Keuangan.</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-gray-800">Keterangan / Rincian Barang <span class="text-danger">*</span></label>
                            <textarea name="keterangan" rows="3" class="form-control" required
                                      placeholder="Contoh: Pembelian restok 15 unit cangkul baja dan 10 unit sabit rumput">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="alert alert-info py-2 px-3 small mb-4">
                            <i class="fas fa-info-circle mr-1"></i> Data pembelian ini otomatis tercatat di tabel <strong>pengeluaran</strong> dan <strong>catatan_keuangan</strong> pada database MySQL.
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success font-weight-bold">
                                <i class="fas fa-save mr-1"></i> Simpan Pembelian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- RIWAYAT PEMBELIAN TERKINI --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history mr-1"></i> Riwayat Pembelian Supplier Terkini
                    </h6>
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-chart-line mr-1"></i> Laporan Keuangan
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0 text-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Supplier</th>
                                    <th>Keterangan</th>
                                    <th class="text-right">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatPembelian as $rp)
                                    <tr>
                                        <td class="font-weight-bold text-nowrap">
                                            {{ \Carbon\Carbon::parse($rp->tanggal)->translatedFormat('d M Y') }}
                                        </td>
                                        <td>
                                            <span class="font-weight-bold text-primary">
                                                {{ $rp->supplier->nama_supplier ?? 'Supplier Umum' }}
                                            </span>
                                            @if($rp->supplier && $rp->supplier->no_telepon)
                                                <br><small class="text-muted"><i class="fas fa-phone fa-xs"></i> {{ $rp->supplier->no_telepon }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($rp->keterangan, 50) }}</small>
                                        </td>
                                        <td class="text-right font-weight-bold text-danger text-nowrap">
                                            -Rp {{ number_format($rp->nominal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fas fa-boxes fa-2x mb-2 text-gray-300"></i>
                                            <p class="mb-0">Belum ada catatan pembelian ke supplier.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function toggleSupplierFields() {
    const sel = document.getElementById('supplier_select');
    const manualBox = document.getElementById('manual_supplier_box');
    const inputNama = document.getElementById('nama_supplier');

    if (sel.value === 'manual' || sel.value === '') {
        manualBox.style.display = 'block';
        if (sel.value === 'manual') {
            inputNama.setAttribute('required', 'required');
            inputNama.focus();
        } else {
            inputNama.removeAttribute('required');
        }
    } else {
        manualBox.style.display = 'none';
        inputNama.removeAttribute('required');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    toggleSupplierFields();
});
</script>
@endpush