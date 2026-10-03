<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::all();

        Produk::factory()
            ->count(20)
            ->recycle($suppliers)
            ->create();
    }
}