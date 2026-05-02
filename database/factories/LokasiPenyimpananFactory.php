<?php

namespace Database\Factories;

use App\Models\LokasiPenyimpanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LokasiPenyimpanan>
 */
class LokasiPenyimpananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_lokasi' => $this->faker->word(),
        ];
    }
}
