<?php

namespace App\Policies;

use App\Models\StokOpname;
use App\Models\User;

class StokOpnamePolicy
{


    public function viewAny(User $user): bool
    {
        return $user->can('stok opname.view');
    }

    public function view(User $user, StokOpname $stokOpname): bool
    {
        return $user->can('stok opname.view');
    }

    public function create(User $user): bool
    {
        return $user->can('stok opname.create');
    }

    public function update(User $user, StokOpname $stokOpname): bool
    {
        return false; // Nonaktifkan update stok opname
    }

    public function delete(User $user, StokOpname $stokOpname): bool
    {
        return false; // Nonaktifkan delete stok opname
    }
}
