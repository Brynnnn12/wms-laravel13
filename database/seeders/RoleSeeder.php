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

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'bryankurniaakbar12@gmail.com',
            'is_active' => true,

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
            'status barang.view',
            'status barang.create',
            'status barang.update',
            'status barang.delete',
            'kondisi barang.view',
            'kondisi barang.create',
            'kondisi barang.update',
            'kondisi barang.delete',
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
            'lokasi penyimpanan.view',
            'lokasi penyimpanan.create',
            'lokasi penyimpanan.update',
            'lokasi penyimpanan.delete',
            'ruangan.view',
            'ruangan.create',
            'ruangan.update',
            'ruangan.delete',
            'barang.view',
            'barang.create',
            'barang.update',
            'barang.delete',
            'stok opname.view',
            'stok opname.create',

        ]);

        // inventaris: barang, penyesuaian, penyusutan
        $inventaris->syncPermissions([
            'barang.view',
            'barang.create',
            'barang.update',
            'barang.delete',
            'penyesuaian.view',
            'penyesuaian.create',
            'penyusutan.view',
            'penyusutan.create',
        ]);

        // keuangan: stok opname, penyusutan
        $keuangan->syncPermissions([
            'stok opname.view',
            'stok opname.create',
            'penyusutan.view',
            'penyusutan.create',
        ]);

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

    }
}
