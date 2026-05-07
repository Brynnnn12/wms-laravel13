<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusBarangs = [
            'Aktif',
            'Tidak Aktif',
            'Dalam Pemeliharaan',
            'Dihapus',
        ];

        foreach ($statusBarangs as $status) {
            \App\Models\StatusBarang::factory()->create([
                'nama_status' => $status,
            ]);
        }
    }
}
