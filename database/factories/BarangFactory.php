<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\JenisBarang;
use App\Models\StatusBarang;
use App\Models\KondisiBarang;
use App\Models\NamaRuang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 1;

        $hargaSatuan = fake()->randomFloat(2, 1000, 1000000);
        $jmlBarang = fake()->numberBetween(1, 100);
        $hargaTotal = $hargaSatuan * $jmlBarang;

        return [
            'kode_barang' => 'BRG-' . now()->format('Y') . '-' . str_pad($counter++, 4, '0', STR_PAD_LEFT),
            'nama_barang' => fake()->unique()->words(2, true),
            'jenis_barang_id' => JenisBarang::factory(),
            'jml_barang' => $jmlBarang,
            'harga_satuan' => $hargaSatuan,
            'harga_total' => $hargaTotal,
            'masa_penyusutan' => fake()->numberBetween(1, 10),
            'nilai_residual' => fake()->randomFloat(2, 0, $hargaSatuan),
            'label' => fake()->optional()->word(),
            'status_barang_id' => StatusBarang::inRandomOrder()->first()->id ?? StatusBarang::factory(),
            'kondisi_barang_id' => KondisiBarang::inRandomOrder()->first()->id ?? KondisiBarang::factory(),
            'nama_ruang_id' => NamaRuang::inRandomOrder()->first()->id ?? NamaRuang::factory(),
            'tahun_anggaran' => fake()->optional()->year(),
            'tanggal_perolehan' => fake()->optional()->date(),
        ];
    }
}
