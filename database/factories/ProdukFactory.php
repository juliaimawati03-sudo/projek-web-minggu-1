<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProdukFactory extends Factory
{
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'nama_produk' => fake()->words(3, true),
            'deskripsi' => fake()->sentence(),
            'harga' => fake()->numberBetween(10000, 500000),
            'stok' => fake()->numberBetween(1, 100),
        ];
    }
}
