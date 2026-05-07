<?php

namespace Database\Factories;

use App\Models\StokOpname;
use App\Models\User;
use App\Models\NamaRuang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StokOpname>
 */
class StokOpnameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tanggal_so' => fake()->date(),
            'nama_ruang_id' => NamaRuang::inRandomOrder()->first()->id ?? NamaRuang::factory(),
            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}
