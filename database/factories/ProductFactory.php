<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'nama_produk' => fake('id_ID')->word() . ' ' . fake('id_ID')->word(),
            'deskripsi' => fake('id_ID')->sentence(),
            'harga' => fake()->numberBetween(10000, 500000),
            'stok' => fake()->numberBetween(10, 100),
        ];
    }
}
