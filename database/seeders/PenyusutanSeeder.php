<?php

namespace Database\Seeders;

use App\Models\Penyusutan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenyusutanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Penyusutan::factory(1)->create();
    }
}
