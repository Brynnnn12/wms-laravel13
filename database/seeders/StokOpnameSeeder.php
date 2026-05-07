<?php

namespace Database\Seeders;

use App\Models\StokOpname;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StokOpnameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StokOpname::factory(2)->create();
    }
}
