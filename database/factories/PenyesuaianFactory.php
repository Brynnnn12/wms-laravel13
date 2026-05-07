<?php

namespace Database\Factories;

use App\Models\Penyesuaian;
use App\Models\StokOpname;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Penyesuaian>
 */
class PenyesuaianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qtySistem = fake()->numberBetween(0, 100);
        $qtyFisik = fake()->numberBetween(0, 100);
        $selisih = $qtyFisik - $qtySistem;

        return [
            'stok_opname_id' => StokOpname::factory(),
            'barang_id' => Barang::factory(),
            'user_id' => User::factory(),
            'qty_sistem' => $qtySistem,
            'qty_fisik' => $qtyFisik,
            'selisih' => $selisih,
            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}
