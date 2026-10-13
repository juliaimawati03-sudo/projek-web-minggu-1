@extends('layouts.admin')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')
@section('page-desc', 'Buku kas — catatan pemasukan dan pengeluaran toko')

@section('content')

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Alert Error --}}
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

    {{-- FILTER PERIODE --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="form-inline">
                <label class="mr-2 font-weight-bold">Periode:</label>
                <input type="date" name="dari" class="form-control mr-2 mb-2"
                       value="{{ $dari ?? now()->startOfMonth()->format('Y-m-d') }}">
                <span class="mr-2 mb-2">s/d</span>
                <input type="date" name="sampai" class="form-control mr-2 mb-2"
                       value="{{ $sampai ?? now()->format('Y-m-d') }}">
                <button type="submit" class="btn btn-success mb-2 mr-2">
                    <i class="fas fa-search mr-1"></i> Tampilkan
                </button>
                <a href="{{ route('admin.laporan.pdf', ['dari' => $dari, 'sampai' => $sampai]) }}"
                   class="btn btn-danger mb-2" target="_blank">
                    <i class="fas fa-file-pdf mr-1"></i> Unduh PDF
                </a>
            </form>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Debit (Pemasukan)
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($totalDebit ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-down fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Kredit (Pengeluaran)
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($totalKredit ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-arrow-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Saldo / Laba Bersih
                            </div>
                            <div class="h4 mb-0 font-weight-bold text-primary">
                                Rp {{ number_format(($totalDebit ?? 0) - ($totalKredit ?? 0), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM INPUT --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-plus-circle mr-1"></i> Input Catatan Keuangan Baru
            </h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info py-2 small mb-3">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Cara isi:</strong> Untuk <span class="text-success font-weight-bold">Pemasukan</span> ketik angka positif
                (contoh: <code>500000</code>). Untuk <span class="text-danger font-weight-bold">Pengeluaran</span> ketik angka negatif
                (contoh: <code>-200000</code>).
            </div>

            <form method="POST" action="{{ route('admin.laporan.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" required
                               value="{{ old('tanggal', now()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold">Nominal (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="nominal" class="form-control" required
                               placeholder="Contoh: 500000 atau -200000"
                               value="{{ old('nominal') }}">
                        <small class="text-muted">Positif = pemasukan, Negatif = pengeluaran</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Keterangan <span class="text-danger">*</span></label>
                        <input type="text" name="keterangan" class="form-control" required maxlength="500"
                               placeholder="Contoh: Penjualan harian" value="{{ old('keterangan') }}">
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL BUKU KAS --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-book mr-1"></i> Buku Kas — Catatan Keuangan
            </h6>
            <a href="{{ route('admin.laporan.pdf', ['dari' => $dari, 'sampai' => $sampai]) }}"
               class="btn btn-sm btn-danger" target="_blank">
                <i class="fas fa-file-pdf mr-1"></i> Unduh PDF
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">No</th>
                            <th width="120">Tanggal</th>
                            <th>Keterangan</th>
                            <th width="150">Dicatat Oleh</th>
                            <th class="text-right" width="130">Debit (Rp)</th>
                            <th class="text-right" width="130">Kredit (Rp)</th>
                            <th class="text-right" width="130">Saldo (Rp)</th>
                            <th width="100" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $saldo = 0; @endphp
                        @forelse($catatan as $i => $c)
                            @php
                                $debit  = $c->nominal > 0 ? $c->nominal : 0;
                                $kredit = $c->nominal < 0 ? abs($c->nominal) : 0;
                                $saldo += $c->nominal;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($c->tanggal)->format('d M Y') }}</td>
                                <td class="font-weight-bold">{{ $c->keterangan }}</td>
                                <td>{{ $c->user->nama ?? '-' }}</td>
                                <td class="text-right {{ $debit > 0 ? 'text-success font-weight-bold' : '' }}">
                                    {{ $debit > 0 ? number_format($debit, 0, ',', '.') : '—' }}
                                </td>
                                <td class="text-right {{ $kredit > 0 ? 'text-danger font-weight-bold' : '' }}">
                                    {{ $kredit > 0 ? number_format($kredit, 0, ',', '.') : '—' }}
                                </td>
                                <td class="text-right font-weight-bold">
                                    {{ number_format($saldo, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    {{-- Tombol Edit --}}
                                    <button type="button" class="btn btn-sm btn-warning"
                                            onclick="editCatatan(
                                                {{ $c->id }},
                                                '{{ $c->tanggal->format('Y-m-d') }}',
                                                {{ $c->nominal }},
                                                '{{ addslashes($c->keterangan) }}'
                                            )">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.laporan.destroy', $c->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus catatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Belum ada catatan keuangan pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($catatan->count() > 0)
                    <tfoot class="bg-light">
                        <tr class="font-weight-bold">
                            <td colspan="4" class="text-right">TOTAL</td>
                            <td class="text-right text-success">
                                Rp {{ number_format($totalDebit ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="text-right text-danger">
                                Rp {{ number_format($totalKredit ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="text-right text-primary">
                                Rp {{ number_format(($totalDebit ?? 0) - ($totalKredit ?? 0), 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            <div class="mt-3 small text-muted">
                <i class="fas fa-info-circle mr-1"></i>
                <strong>Debit</strong> = pemasukan (nominal positif) &nbsp;|&nbsp;
                <strong>Kredit</strong> = pengeluaran (nominal negatif) &nbsp;|&nbsp;
                <strong>Saldo</strong> = akumulasi Debit − Kredit
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div class="modal fade" id="modalEditCatatan" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditCatatan" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Catatan Keuangan</h5>
                        <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tanggal *</label>
                            <input type="date" id="editTanggal" name="tanggal" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nominal (Rp) *</label>
                            <input type="number" id="editNominal" name="nominal" class="form-control" required>
                            <small class="text-muted">Positif = pemasukan, Negatif = pengeluaran</small>
                        </div>
                        <div class="form-group">
                            <label>Keterangan *</label>
                            <input type="text" id="editKeterangan" name="keterangan" class="form-control" required maxlength="500">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
function editCatatan(id, tanggal, nominal, keterangan) {
    document.getElementById('formEditCatatan').action = '/admin/laporan/' + id;
    document.getElementById('editTanggal').value = tanggal;
    document.getElementById('editNominal').value = nominal;
    document.getElementById('editKeterangan').value = keterangan;
    $('#modalEditCatatan').modal('show');
}
</script>
@endpush