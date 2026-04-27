<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Role::query()
            ->withCount(['users', 'permissions'])
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function permissions(): Collection
    {
        return Permission::query()
            ->orderBy('name')
            ->get(['id', 'name', 'guard_name']);
    }

    public function permissionNamesByIds(array $permissionIds, string $guardName): array
    {
        return Permission::query()
            ->where('guard_name', $guardName)
            ->whereIn('id', $permissionIds)
            ->pluck('name')
            ->all();
    }

    public function create(array $payload): Role
    {
        return Role::query()->create($payload);
    }

    public function update(Role $role, array $payload): Role
    {
        $role->update($payload);

        return $role->refresh();
    }

    public function delete(Role $role): bool
    {
        return (bool) $role->delete();
    }
}
