<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            JenisBarangSeeder::class,
            StatusBarangSeeder::class,
            KondisiBarangSeeder::class,
            LokasiPenyimpananSeeder::class,
            NamaRuangSeeder::class,
            BarangSeeder::class,
        ]);
    }
}
