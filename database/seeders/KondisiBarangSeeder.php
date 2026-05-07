<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KondisiBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kondisiBarangs = [
            'Baik',
            'Rusak Ringan',
            'Rusak Berat',
            'Hilang',
            'Dalam Perbaikan',
        ];

        foreach ($kondisiBarangs as $kondisi) {
            \App\Models\KondisiBarang::factory()->create([
                'nama_kondisi' => $kondisi,
            ]);
        }
    }
}
