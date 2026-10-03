<?php

namespace Database\Factories;

use App\Models\CatatanKeuangan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatatanKeuangan>
 */
class CatatanKeuanganFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tanggal' => fake()->date(),
            'nominal' => fake()->numberBetween(10000, 2000000),
            'keterangan' => fake()->sentence(),
        ];
    }
}