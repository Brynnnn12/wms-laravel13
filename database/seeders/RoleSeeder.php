<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $inventaris = Role::firstOrCreate([
            'name' => 'inventaris',
            'guard_name' => 'web',
        ]);

        $keuangan = Role::firstOrCreate([
            'name' => 'keuangan',
            'guard_name' => 'web',
        ]);

        //buat user role super admin
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'bryankurniaakbar12@gmail.com',
        ])->assignRole($superAdmin);

        //buat user role admin
        User::factory()->create([
            'name' => 'Inventaris',
            'email' => 'inventaris@example.com',
        ])->assignRole($inventaris);

        //buat user role keuangan
        User::factory()->create([
            'name' => 'Keuangan',
            'email' => 'keuangan@example.com',
        ])->assignRole($keuangan);

        // super admin semua permission
        $superAdmin->syncPermissions([
            'jenis barang.view',
            'jenis barang.create',
            'jenis barang.update',
            'jenis barang.delete',
            'jenis barang.restore',
            'jenis barang.force delete',
        ]);

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

    }
}
