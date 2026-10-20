<?php

namespace Database\Seeders;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Database\Seeder;

class DetailTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $transaksis = Transaksi::all();
        $produk = Produk::all();

        DetailTransaksi::factory()
            ->count(30)
            ->recycle($transaksis)
            ->recycle($produk)
            ->create();
    }
}