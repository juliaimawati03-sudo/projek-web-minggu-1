@extends('layouts.kasir')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')
@section('page-desc', 'Verifikasi pembayaran dan kelola status proses pesanan')

@section('content')

    <a href="{{ route('kasir.pesanan.index') }}" class="btn btn-sm btn-secondary mb-3">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar Pesanan
    </a>

    @php
        $statusClass = match($pesanan->status) {
            'menunggu_verifikasi' => 'badge-warning',
            'diproses' => 'badge-info',
            'dikirim' => 'badge-primary',
            'selesai' => 'badge-success',
            default => 'badge-danger',
        };
        $statusLabel = match($pesanan->status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'dikirim' => 'Sedang Dikirim',
            'selesai' => 'Selesai',
            default => 'Ditolak',
        };
        $kode = $pesanan->kode_transaksi ?? ('ORD-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT));
    @endphp

    <div class="row">

        {{-- Kolom Kiri: Detail Pesanan --}}
        <div class="col-lg-8 mb-4">

            <div class="card shadow mb-4">
                <div class="card-header py-3 text-white" style="background: linear-gradient(135deg, #16A34A 0%, #15803D 100%);">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <div class="small text-white-50 mb-1">Nomor Pesanan</div>
                            <div class="font-weight-bold" style="font-family: monospace; font-size: 20px;">
                                {{ $kode }}
                            </div>
                        </div>
                        <span class="badge {{ $statusClass }} p-2" style="font-size: 13px;">
                            <i class="fas fa-info-circle mr-1"></i> {{ $statusLabel }}
                        </span>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Data Pelanggan --}}
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-user text-success mr-1"></i> Data Pemesan
                    </h6>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small mb-1">Nama Lengkap</div>
                            <div class="font-weight-bold">{{ $pesanan->nama_pelanggan ?? ($pesanan->pelanggan->nama ?? '-') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small mb-1">Nomor WhatsApp / HP</div>
                            <div class="font-weight-bold">
                                @if($pesanan->no_hp)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $pesanan->no_hp)) }}" target="_blank" class="text-success font-weight-bold">
                                        <i class="fab fa-whatsapp mr-1"></i> {{ $pesanan->no_hp }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="text-muted small mb-1">Alamat Pengantaran / Domisili</div>
                            <div class="font-weight-bold">{{ $pesanan->alamat ?? '-' }}</div>
                        </div>

                        @if($pesanan->latitude && $pesanan->longitude)
                        <div class="col-12 mb-3">
                            <div class="text-muted small mb-1">Titik Koordinat Pengantaran (Google Maps)</div>
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <span class="badge badge-light border font-weight-bold text-dark px-2 py-1 mr-2">
                                    <i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $pesanan->latitude }}, {{ $pesanan->longitude }}
                                </span>
                                <a href="https://www.google.com/maps?q={{ $pesanan->latitude }},{{ $pesanan->longitude }}" target="_blank" class="btn btn-sm btn-outline-success py-1 px-3">
                                    <i class="fas fa-directions mr-1"></i> Buka Petunjuk Rute Maps
                                </a>
                            </div>
                        </div>
                        @endif

                        <div class="col-12">
                            <div class="text-muted small mb-1">Catatan Tambahan</div>
                            <div class="font-italic text-neutral-700 bg-light p-2.5 rounded border">
                                {{ $pesanan->catatan ?: 'Tidak ada catatan tambahan.' }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Produk Dipesan --}}
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-shopping-cart text-success mr-1"></i> Produk Dipesan
                    </h6>

                    @forelse($pesanan->detailTransaksis as $d)
                        <div class="d-flex align-items-center mb-2 p-3 bg-light rounded border">
                            <div class="rounded bg-success text-white d-flex align-items-center justify-content-center mr-3"
                                 style="width: 44px; height: 44px; font-size: 18px;">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold text-dark">{{ $d->produk->nama_produk ?? 'Alat Pertanian' }}</div>
                                <div class="text-muted small">
                                    Rp {{ number_format($d->harga_satuan, 0, ',', '.') }} × {{ $d->jumlah }} unit
                                </div>
                            </div>
                            <div class="font-weight-bold text-dark">
                                Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-light text-center">Tidak ada rincian produk pada transaksi ini.</div>
                    @endforelse

                    <div class="bg-light p-3 rounded mt-3 border">
                        @if($pesanan->ongkir > 0)
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Ongkos Kirim:</span>
                                <span class="font-weight-bold">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center pt-2 {{ $pesanan->ongkir > 0 ? 'border-top' : '' }}">
                            <span class="font-weight-bold text-dark" style="font-size: 16px;">Total Keseluruhan</span>
                            <span class="h4 mb-0 font-weight-bold text-success">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    {{-- Bukti Pembayaran --}}
                    <h6 class="font-weight-bold text-dark mb-3">
                        <i class="fas fa-camera text-success mr-1"></i> Bukti Pembayaran
                    </h6>
                    <div class="bg-light rounded p-3 border">
                        <div class="mb-2">
                            <span class="text-muted small">Metode Pembayaran:</span>
                            <strong class="ml-1 text-dark">{{ $pesanan->metode_pembayaran ?? 'Tunai' }}</strong>
                        </div>

                        @if($pesanan->bukti_transfer)
                            @php
                                $imgSrc = str_starts_with($pesanan->bukti_transfer, 'http')
                                    ? $pesanan->bukti_transfer
                                    : (file_exists(storage_path('app/public/' . $pesanan->bukti_transfer))
                                        ? asset('storage/' . $pesanan->bukti_transfer)
                                        : 'https://placehold.co/800x500/22c55e/ffffff?text=Bukti+Transfer+' . urlencode($pesanan->metode_pembayaran));
                            @endphp
                            <div class="text-center">
                                <img src="{{ $imgSrc }}"
                                     alt="Bukti Transfer"
                                     class="img-fluid rounded border mb-2"
                                     style="max-height: 400px; object-fit: contain;">
                                <div class="text-muted small">
                                    <i class="fas fa-paperclip mr-1"></i> {{ $pesanan->bukti_transfer }}
                                </div>
                            </div>
                        @else
                            <div class="alert alert-secondary small text-center mb-0">
                                <i class="fas fa-info-circle mr-1"></i> Tidak ada file bukti transfer (Pembayaran Tunai / COD di Tempat).
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Status & Aksi --}}
        <div class="col-lg-4 mb-4">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-tasks mr-1"></i> Tindakan Kasir
                    </h6>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Status Saat Ini:</small>
                        <span class="badge {{ $statusClass }} p-2 d-block text-center font-weight-bold" style="font-size: 14px;">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    @if($pesanan->status === 'menunggu_verifikasi')
                        {{-- Verifikasi Pembayaran --}}
                        <form action="{{ route('kasir.pesanan.verifikasi', $pesanan->id) }}" method="POST"
                              onsubmit="return confirm('Verifikasi pembayaran untuk pesanan ini?\n\nStatus akan langsung berubah menjadi DIPROSES.')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block mb-2 font-weight-bold">
                                <i class="fas fa-check-circle mr-1"></i> Verifikasi Pembayaran (Diproses)
                            </button>
                        </form>

                        {{-- Tolak Bukti Transfer --}}
                        <form action="{{ route('kasir.pesanan.tolak', $pesanan->id) }}" method="POST"
                              onsubmit="return confirm('Tolak bukti transfer pesanan ini?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-block mb-3">
                                <i class="fas fa-times-circle mr-1"></i> Tolak Bukti Transfer
                            </button>
                        </form>
                    @endif

                    @if($pesanan->status === 'diproses')
                        <form action="{{ route('kasir.pesanan.status', $pesanan->id) }}" method="POST"
                              onsubmit="return confirm('Tandai pesanan telah dikirim atau siap diambil?')">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="dikirim">
                            <button type="submit" class="btn btn-primary btn-block mb-3 font-weight-bold">
                                <i class="fas fa-truck mr-1"></i> Tandai Sedang Dikirim
                            </button>
                        </form>
                    @endif

                    @if($pesanan->status === 'dikirim')
                        <form action="{{ route('kasir.pesanan.status', $pesanan->id) }}" method="POST"
                              onsubmit="return confirm('Tandai pesanan telah selesai dan diterima pelanggan?')">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn btn-success btn-block mb-3 font-weight-bold">
                                <i class="fas fa-check-double mr-1"></i> Tandai Selesai (Lunas)
                            </button>
                        </form>
                    @endif

                    @if($pesanan->status === 'selesai')
                        <div class="alert alert-success text-center font-weight-bold py-2 mb-3">
                            <i class="fas fa-check-circle mr-1"></i> Pesanan Selesai & Lunas
                        </div>
                    @endif

                    {{-- Form Ubah Status Bebas --}}
                    <div class="border-top pt-3">
                        <small class="font-weight-bold text-dark d-block mb-2">Ubah Status Manual:</small>
                        <form action="{{ route('kasir.pesanan.status', $pesanan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="input-group">
                                <select name="status" class="form-control form-control-sm">
                                    <option value="menunggu_verifikasi" {{ $pesanan->status === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="diproses" {{ $pesanan->status === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="dikirim" {{ $pesanan->status === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                    <option value="selesai" {{ $pesanan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ $pesanan->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-secondary" type="submit">Ubah</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            {{-- Kartu Info Kasir --}}
            <div class="card shadow-sm border-left-success">
                <div class="card-body">
                    <h6 class="font-weight-bold text-success mb-2">
                        <i class="fas fa-info-circle mr-1"></i> Panduan Kasir
                    </h6>
                    <ul class="small text-muted pl-3 mb-0">
                        <li><strong>Verifikasi:</strong> Pastikan nominal dan nama pengirim di bukti transfer sesuai dengan total belanja.</li>
                        <li><strong>Diproses:</strong> Bagian gudang menyiapkan alat pertanian yang dipesan.</li>
                        <li><strong>Dikirim / Selesai:</strong> Transaksi berstatus selesai otomatis tercatat di <strong>Riwayat Transaksi Kasir</strong>.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

@endsection