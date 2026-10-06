@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas toko alat pertanian hari ini')

@section('content')

<!-- Statistik -->

<div class="row">

```
<!-- Transaksi Hari Ini -->
<div class="col-xl-3 col-md-6 mb-4">

    <div class="card border-left-primary shadow h-100 py-2">

        <div class="card-body">

            <div class="row no-gutters align-items-center">

                <div class="col mr-2">

                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Transaksi Hari Ini
                    </div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $totalTransaksiHariIni ?? 18 }}
                    </div>

                    <div class="text-xs text-success mt-2">
                        <i class="fas fa-arrow-up"></i>
                        +12% dari kemarin
                    </div>

                </div>

                <div class="col-auto">
                    <i class="fas fa-receipt fa-2x text-gray-300"></i>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- Pemasukan -->
<div class="col-xl-3 col-md-6 mb-4">

    <div class="card border-left-success shadow h-100 py-2">

        <div class="card-body">

            <div class="row no-gutters align-items-center">

                <div class="col mr-2">

                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Pemasukan Hari Ini
                    </div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Rp {{ number_format($pemasukanHariIni ?? 2450000, 0, ',', '.') }}
                    </div>

                    <div class="text-xs text-gray-500 mt-2">
                        Dari {{ $totalTransaksiHariIni ?? 18 }} transaksi
                    </div>

                </div>

                <div class="col-auto">
                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- Pengeluaran -->
<div class="col-xl-3 col-md-6 mb-4">

    <div class="card border-left-danger shadow h-100 py-2">

        <div class="card-body">

            <div class="row no-gutters align-items-center">

                <div class="col mr-2">

                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        Pengeluaran Hari Ini
                    </div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Rp {{ number_format($pengeluaranHariIni ?? 850000, 0, ',', '.') }}
                    </div>

                    <div class="text-xs text-gray-500 mt-2">
                        Pembelian ke supplier
                    </div>

                </div>

                <div class="col-auto">
                    <i class="fas fa-wallet fa-2x text-gray-300"></i>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- Stok Menipis -->
<div class="col-xl-3 col-md-6 mb-4">

    <div class="card border-left-warning shadow h-100 py-2">

        <div class="card-body">

            <div class="row no-gutters align-items-center">

                <div class="col mr-2">

                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Stok Menipis
                    </div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $produkStokMenipis ?? 4 }} Produk
                    </div>

                    <div class="text-xs text-gray-500 mt-2">
                        Stok di bawah 10 unit
                    </div>

                </div>

                <div class="col-auto">
                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                </div>

            </div>

        </div>

    </div>

</div>
```

</div>

<!-- Transaksi Terbaru -->

<div class="card shadow mb-4">

```
<!-- Header -->
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

    <h6 class="m-0 font-weight-bold text-primary">
        Transaksi Terbaru
    </h6>

    <a href="{{ route('admin.transaksi.index') }}"
       class="btn btn-sm btn-primary">

        Lihat Semua
        <i class="fas fa-arrow-right ml-1"></i>

    </a>

</div>


<!-- Table -->
<div class="card-body">

    <div class="table-responsive">

        <table class="table table-bordered table-hover" width="100%" cellspacing="0">

            <thead class="thead-light">

                <tr>

                    <th>ID Transaksi</th>
                    <th>Kasir</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse(($transaksiTerbaru ?? []) as $t)

                <tr>

                    <td class="font-weight-bold">
                        #TRX-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}
                    </td>

                    <td>
                        {{ $t->kasir->nama ?? '-' }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y, H:i') }}
                    </td>

                    <td class="font-weight-bold">
                        Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                    </td>

                    <td>

                        <span class="badge badge-success">
                            <i class="fas fa-check mr-1"></i>
                            Selesai
                        </span>

                    </td>

                </tr>

                @empty

                <!-- Data contoh -->
                <tr>

                    <td class="font-weight-bold">
                        #TRX-0124
                    </td>

                    <td>
                        Siti Aminah
                    </td>

                    <td>
                        25 Sep 2026, 10:12
                    </td>

                    <td class="font-weight-bold">
                        Rp 350.000
                    </td>

                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check mr-1"></i>
                            Selesai
                        </span>
                    </td>

                </tr>


                <tr>

                    <td class="font-weight-bold">
                        #TRX-0123
                    </td>

                    <td>
                        Budi Santoso
                    </td>

                    <td>
                        25 Sep 2026, 09:47
                    </td>

                    <td class="font-weight-bold">
                        Rp 1.250.000
                    </td>

                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check mr-1"></i>
                            Selesai
                        </span>
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
```

</div>

@endsection
