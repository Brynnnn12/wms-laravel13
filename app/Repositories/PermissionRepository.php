<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PermissionRepository
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Permission::query()
            ->withCount(['roles', 'users'])
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function roles(): Collection
    {
        return Role::query()
            ->orderBy('name')
            ->get(['id', 'name', 'guard_name']);
    }


    public function roleNamesByIds(array $ids, string $guardName): array
    {
        // WAJIB difilter berdasarkan guard_name agar sinkron
        return Role::whereIn('id', $ids)
            ->where('guard_name', $guardName)
            ->pluck('name')
            ->toArray();
    }
    public function create(array $payload): Permission
    {
        return Permission::query()->create($payload);
    }

    public function update(Permission $permission, array $payload): Permission
    {
        $permission->update($payload);

        return $permission->refresh();
    }

    public function delete(Permission $permission): bool
    {
        return (bool) $permission->delete();
    }
}
