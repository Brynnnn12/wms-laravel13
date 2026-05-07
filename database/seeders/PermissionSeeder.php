<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
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
            'penyusutan.view',
            'penyusutan.create',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
