<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisBarangs = [
            'Elektronik',
            'Pakaian',
            'Makanan',
            'Minuman',
            'Kosmetik',
            'Obat-obatan',
            'Perabotan',
            'Otomotif',
            'Buku',
            'Mainan',
        ];

        foreach ($jenisBarangs as $jenis) {
            \App\Models\JenisBarang::factory()->create([
                'jenis_barang' => $jenis,
            ]);
        }
    }
}
