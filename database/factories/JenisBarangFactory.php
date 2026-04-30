<?php

namespace Database\Factories;

use App\Models\JenisBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JenisBarang>
 */
class JenisBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 1;

        return [
            'kode_jenis' => 'JNS-' . now()->format('Y') . '-' . str_pad($counter++, 3, '0', STR_PAD_LEFT),
            'jenis_barang' => fake()->unique()->word(),
        ];
    }
}
