<?php

namespace App\Policies;

use App\Models\StokOpname;
use App\Models\User;

class StokOpnamePolicy
{
    /**
     * Digunakan untuk mengecek akses ke halaman index (list).
     * Superadmin bisa akses semua, user biasa cek permission.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('stok opname.view');
    }

    /**
     * Digunakan untuk mengecek akses melihat detail (show).
     * Inventaris hanya bisa melihat miliknya sendiri.
     */
    public function view(User $user, StokOpname $stokOpname): bool
    {
        // 2. Jika bukan superadmin, cek apakah punya permission DAN apakah miliknya sendiri.
        return $user->can('stok opname.view') && $user->id === $stokOpname->user_id;
    }

    public function create(User $user): bool
    {
        return $user->can('stok opname.create');
    }

    public function update(User $user, StokOpname $stokOpname): bool
    {
        // Tetap false sesuai keinginan Anda sebelumnya (Data Stok Opname tidak boleh diedit)
        return false;
    }

    public function delete(User $user, StokOpname $stokOpname): bool
    {
        // Tetap false sesuai keinginan Anda sebelumnya (Data Stok Opname tidak boleh dihapus)
        return false;
    }
}
