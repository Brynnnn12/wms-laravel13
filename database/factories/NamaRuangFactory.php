<?php

namespace Database\Factories;

use App\Models\NamaRuang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NamaRuang>
 */
class NamaRuangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_ruang' => $this->faker->word(),
            'lokasi_penyimpanan_id' => \App\Models\LokasiPenyimpanan::factory(),
        ];
    }
}
