<?php

namespace Database\Factories;

use App\Models\KondisiBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KondisiBarang>
 */
class KondisiBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kondisi' => fake()->unique()->word(),
        ];
    }
}
