<?php

namespace Database\Seeders;

use App\Models\Penyesuaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenyesuaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penyesuaian::factory(30)->create();
    }
}
