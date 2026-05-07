<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NamaRuangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $namaRuangs = [
            'Ruang A1',
            'Ruang A2',
            'Ruang B1',
            'Ruang B2',
            'Ruang C1',
        ];

        foreach ($namaRuangs as $ruang) {
            \App\Models\NamaRuang::factory()->create([
                'nama_ruang' => $ruang,
                'lokasi_penyimpanan_id' => \App\Models\LokasiPenyimpanan::inRandomOrder()->first()->id,
            ]);
        }
    }
}
