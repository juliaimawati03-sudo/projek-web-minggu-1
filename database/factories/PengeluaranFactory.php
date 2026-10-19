<?php

namespace Database\Factories;

use App\Models\Pengeluaran;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pengeluaran>
 */
class PengeluaranFactory extends Factory
{
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'tanggal' => fake()->date(),
            'nominal' => fake()->numberBetween(50000, 2000000),
            'keterangan' => fake()->sentence(),
        ];
    }
}
