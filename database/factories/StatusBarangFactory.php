<?php

namespace Database\Factories;

use App\Models\StatusBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StatusBarang>
 */
class StatusBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_status' => fake()->unique()->word(),
        ];
    }
}
