<?php

namespace App\Policies;

use App\Models\JenisBarang;
use App\Models\User;

class JenisBarangPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('jenis barang.view');
    }

    public function view(User $user, JenisBarang $jenisBarang): bool
    {
        return $user->can('jenis barang.view');
    }

    public function create(User $user): bool
    {
        return $user->can('jenis barang.create');
    }

    public function update(User $user, JenisBarang $jenisBarang): bool
    {
        return $user->can('jenis barang.update');
    }

    public function delete(User $user, JenisBarang $jenisBarang): bool
    {
        return $user->can('jenis barang.delete');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('jenis barang.delete');
    }

    public function restore(User $user, JenisBarang $jenisBarang): bool
    {
        return $user->can('jenis barang.restore');
    }

    public function forceDelete(User $user, JenisBarang $jenisBarang): bool
    {
        return $user->can('jenis barang.force delete');
    }
}
