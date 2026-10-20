<?php

namespace Database\Seeders;

use App\Models\Pengeluaran;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();

        Pengeluaran::factory()
            ->count(15)
            ->recycle($suppliers)
            ->create();
    }
}