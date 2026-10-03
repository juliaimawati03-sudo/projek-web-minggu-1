<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SupplierSeeder::class,
            ProdukSeeder::class,
            TransaksiSeeder::class,
            DetailTransaksiSeeder::class,
            PengeluaranSeeder::class,
            CatatanKeuanganSeeder::class,
        ]);
    }
}