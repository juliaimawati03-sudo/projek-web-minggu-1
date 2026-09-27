<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'tanggal' => fake()->date(),
            'nominal' => fake()->numberBetween(100000, 5000000),
            'keterangan' => fake('id_ID')->sentence(),
        ];
    }
}
