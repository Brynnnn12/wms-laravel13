<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. BUAT ROLE
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $inventaris = Role::firstOrCreate(['name' => 'inventaris', 'guard_name' => 'web']);
        $keuangan = Role::firstOrCreate(['name' => 'keuangan', 'guard_name' => 'web']);

        // 2. ASSIGN PERMISSIONS KE ROLE

        // Super Admin: Bisa semua (mengambil semua nama permission dari database)
        $allPermissions = Permission::all();
        $superAdmin->syncPermissions($allPermissions);

        // Inventaris: Lokasi, Ruang, Jenis Barang, Barang, Penyesuaian
        $inventaris->syncPermissions([
            'lokasi penyimpanan.view', 'lokasi penyimpanan.create', 'lokasi penyimpanan.update', 'lokasi penyimpanan.delete',
            'ruangan.view', 'ruangan.create', 'ruangan.update', 'ruangan.delete',
            'jenis barang.view', 'jenis barang.create', 'jenis barang.update', 'jenis barang.delete',
            'barang.view', 'barang.create', 'barang.update', 'barang.delete',
            'penyesuaian.view', 'penyesuaian.create', 'penyesuaian.update', 'penyesuaian.delete',
            'kondisi barang.view', 'status barang.view', // Tambahan agar bisa melihat referensi saat input barang
            'stok opname.view', // Inventaris perlu akses untuk buat dan lihat stok opname
        ]);

        // Keuangan: Laporan SO (Stok Opname) dan Laporan Penyusutan
        $keuangan->syncPermissions([
            'stok opname.view',
            'stok opname.create', // Biasanya keuangan perlu 'create' untuk generate sesi opname
            'penyusutan.view',
            'penyusutan.create' // Biasanya keuangan yang men-trigger proses penyusutan
        ]);

        // 3. BUAT USER DUMMY (Jika belum ada)

        // Super Admin
        $userSuper = User::updateOrCreate(
            ['email' => 'bryankurniaakbar12@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'), // Ganti sesuai kebutuhan
                'is_active' => true,
            ]
        );
        $userSuper->assignRole($superAdmin);

        // User Inventaris
        $userInv = User::updateOrCreate(
            ['email' => 'inventaris@example.com'],
            [
                'name' => 'Staff Inventaris',
                'password' => bcrypt('password'),
            ]
        );
        $userInv->assignRole($inventaris);

        // User Keuangan
        $userKeu = User::updateOrCreate(
            ['email' => 'keuangan@example.com'],
            [
                'name' => 'Staff Keuangan',
                'password' => bcrypt('password'),
            ]
        );
        $userKeu->assignRole($keuangan);
    }
}
