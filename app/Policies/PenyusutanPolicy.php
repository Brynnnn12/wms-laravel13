<?php

namespace App\Policies;

use App\Models\Penyusutan;
use App\Models\User;

class PenyusutanPolicy
{
    /**
     * Tentukan apakah user dapat melihat laporan penyusutan.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['super-admin', 'keuangan']);
    }

    /**
     * Tentukan apakah user dapat melihat detail penyusutan.
     */
    public function view(User $user, Penyusutan $penyusutan): bool
    {
        return $user->hasRole(['super-admin', 'keuangan']);
    }

    /**
     * Tentukan apakah user dapat melakukan generate penyusutan.
     */
    public function generate(User $user): bool
    {
        return $user->hasRole(['super-admin', 'keuangan']);
    }
}
