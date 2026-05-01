<?php

namespace App\Policies;

use App\Models\StatusBarang;
use App\Models\User;

class StatusBarangPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('status barang.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, StatusBarang $status_barang): bool
    {
        return $user->can('status barang.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('status barang.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, StatusBarang $status_barang): bool
    {
        return $user->can('status barang.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, StatusBarang $status_barang): bool
    {
        return $user->can('status barang.delete');
    }

    /**
     * Determine whether the user can bulk delete models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('status barang.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, StatusBarang $status_barang): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, StatusBarang $status_barang): bool
    {
        return false;
    }
}
