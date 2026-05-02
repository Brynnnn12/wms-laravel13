<?php

namespace App\Policies;

use App\Models\LokasiPenyimpanan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LokasiPenyimpananPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('lokasi penyimpanan.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LokasiPenyimpanan $lokasiPenyimpanan): bool
    {
        return $user->can('lokasi penyimpanan.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('lokasi penyimpanan.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LokasiPenyimpanan $lokasiPenyimpanan): bool
    {
        return $user->can('lokasi penyimpanan.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LokasiPenyimpanan $lokasiPenyimpanan): bool
    {
        return $user->can('lokasi penyimpanan.delete');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('lokasi penyimpanan.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LokasiPenyimpanan $lokasiPenyimpanan): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LokasiPenyimpanan $lokasiPenyimpanan): bool
    {
        return false;
    }
}
