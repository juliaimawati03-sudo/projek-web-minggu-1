<?php

namespace Database\Seeders;

use App\Models\Pengeluaran;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();
        if ($suppliers->isEmpty()) {
            return;
        }

        $pengeluaran = [
            [
                'supplier_id' => $suppliers[0]->id,
                'tanggal' => Carbon::now()->subDays(6)->format('Y-m-d'),
                'nominal' => 1500000,
                'keterangan' => 'Restock 20 unit Cangkul Baja EGA Super Kuat',
            ],
            [
                'supplier_id' => $suppliers[1]->id ?? $suppliers[0]->id,
                'tanggal' => Carbon::now()->subDays(4)->format('Y-m-d'),
                'nominal' => 850000,
                'keterangan' => 'Kulakan 10 roll Mulsa Plastik Hitam Perak',
            ],
            [
                'supplier_id' => $suppliers[4]->id ?? $suppliers[0]->id,
                'tanggal' => Carbon::now()->subDay()->format('Y-m-d'),
                'nominal' => 600000,
                'keterangan' => 'Kulakan Arit Rumput 15 unit dan Parang 5 unit',
            ],
        ];

        foreach ($pengeluaran as $p) {
            Pengeluaran::create($p);
        }
    }
}
