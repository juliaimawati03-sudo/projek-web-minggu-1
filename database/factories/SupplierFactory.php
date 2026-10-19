<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Supplier>
 */
class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_supplier' => fake()->company(),
            'no_telepon' => fake()->phoneNumber(),
            'alamat' => fake()->address(),
        ];
    }
}
