<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LokasiPenyimpananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokasiPenyimpanans = [
            'Gudang Utama',
            'Gudang Cadangan',
            'Ruang Server',
            'Ruang Kantor',
            'Ruang Produksi',
        ];

        foreach ($lokasiPenyimpanans as $lokasi) {
            \App\Models\LokasiPenyimpanan::factory()->create([
                'nama_lokasi' => $lokasi,
            ]);
        }
    }
}
