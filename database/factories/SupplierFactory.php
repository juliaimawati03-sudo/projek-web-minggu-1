<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama_supplier' => fake('id_ID')->company(),
            'no_telepon' => fake('id_ID')->phoneNumber(),
            'alamat' => fake('id_ID')->address(),
        ];
    }
}
