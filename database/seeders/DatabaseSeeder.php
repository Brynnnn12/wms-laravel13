<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Role Spatie
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $karyawanRole = Role::create(['name' => 'admin']);

        // 2. Buat 1 User super-admin (Biasanya admin tidak ada di tabel employee)
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Ganti dengan password yang aman
        ]);
        $superAdmin->assignRole($superAdminRole);

    }
}
