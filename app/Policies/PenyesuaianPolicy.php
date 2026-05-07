<?php

namespace App\Policies;

use App\Models\Penyesuaian;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PenyesuaianPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('penyesuaian.view');
    }

    public function view(User $user, Penyesuaian $penyesuaian): bool
    {
        return $user->can('penyesuaian.view') && $user->id === $penyesuaian->user_id;
    }

    public function create(User $user): bool
    {
        return $user->can('penyesuaian.create');
    }

    public function update(User $user, Penyesuaian $penyesuaian): bool
    {
        return $user->can('penyesuaian.create') && $user->id === $penyesuaian->user_id;
    }

    public function delete(User $user, Penyesuaian $penyesuaian): bool
    {
        return false; // Tidak boleh delete
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Penyesuaian $penyesuaian): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Penyesuaian $penyesuaian): bool
    {
        return false;
    }
}
