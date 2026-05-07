<?php

namespace Database\Factories;

use App\Models\Penyusutan;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Penyusutan>
 */
class PenyusutanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nilaiAwal = fake()->randomFloat(2, 10000, 1000000);
        $nilaiPenyusutan = fake()->randomFloat(2, 100, $nilaiAwal / 10);
        $akumulasiPenyusutan = fake()->randomFloat(2, 0, $nilaiAwal);
        $nilaiBuku = $nilaiAwal - $akumulasiPenyusutan;

        return [
            'barang_id' => Barang::factory(),
            'bulan' => fake()->numberBetween(1, 12),
            'tahun' => fake()->year(),
            'nilai_awal' => $nilaiAwal,
            'nilai_penyusutan' => $nilaiPenyusutan,
            'akumulasi_penyusutan' => $akumulasiPenyusutan,
            'nilai_buku' => $nilaiBuku,
            'generated_at' => fake()->optional()->dateTime(),
        ];
    }
}
