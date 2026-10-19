<?php

namespace Database\Seeders;

use App\Models\CatatanKeuangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatatanKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin?->id;

        $catatan = [
            [
                'user_id' => $adminId,
                'tanggal' => Carbon::now()->subDays(6)->format('Y-m-d'),
                'nominal' => -1500000,
                'keterangan' => 'Pembelian dari CV Tani Makmur Jombang — Restock 20 unit Cangkul Baja EGA',
            ],
            [
                'user_id' => $adminId,
                'tanggal' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'nominal' => 450000,
                'keterangan' => 'Pemasukan Penjualan Kasir TRX-20261014-0010',
            ],
            [
                'user_id' => $adminId,
                'tanggal' => Carbon::now()->subDays(4)->format('Y-m-d'),
                'nominal' => -850000,
                'keterangan' => 'Pembelian dari UD Sumber Subur Mojokerto — Kulakan 10 roll Mulsa Plastik',
            ],
            [
                'user_id' => $adminId,
                'tanggal' => Carbon::now()->subDays(4)->format('Y-m-d'),
                'nominal' => 280000,
                'keterangan' => 'Pemasukan Penjualan Kasir TRX-20261015-0009',
            ],
            [
                'user_id' => $adminId,
                'tanggal' => Carbon::now()->subDays(3)->format('Y-m-d'),
                'nominal' => 175000,
                'keterangan' => 'Pemasukan Penjualan Kasir TRX-20261016-0008',
            ],
            [
                'user_id' => $adminId,
                'tanggal' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'nominal' => 350000,
                'keterangan' => 'Pemasukan Penjualan Kasir TRX-20261017-0006 (Pak Joko Santoso)',
            ],
            [
                'user_id' => $adminId,
                'tanggal' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'nominal' => 1250000,
                'keterangan' => 'Pemasukan Penjualan Kasir TRX-20261017-0007 (Kelompok Tani Tembelang)',
            ],
            [
                'user_id' => $adminId,
                'tanggal' => Carbon::now()->subDay()->format('Y-m-d'),
                'nominal' => -600000,
                'keterangan' => 'Pembelian dari Sentra Baja Logam Tani Klaten — Kulakan Arit Rumput 15 unit',
            ],
            [
                'user_id' => $adminId,
                'tanggal' => Carbon::now()->subDay()->format('Y-m-d'),
                'nominal' => 290000,
                'keterangan' => 'Pemasukan Pesanan Online ORD-20261018-0004 (Rina Wati)',
            ],
            [
                'user_id' => $adminId,
                'tanggal' => Carbon::now()->format('Y-m-d'),
                'nominal' => 225000,
                'keterangan' => 'Pemasukan Pesanan Online ORD-20261019-0001 (Budi Santoso)',
            ],
        ];

        foreach ($catatan as $c) {
            CatatanKeuangan::create($c);
        }
    }
}
