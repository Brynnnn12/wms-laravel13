<?php

namespace App\Services;

use App\Models\Permission;
use App\Repositories\PermissionRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\PermissionRegistrar;

class PermissionService
{
    public function __construct(
        private readonly PermissionRepository $permissionRepository,
    ) {
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->permissionRepository->paginate($perPage);
    }

    public function roles(): Collection
    {
        return $this->permissionRepository->roles();
    }

    public function create(array $validated): Permission
    {
        return DB::transaction(function () use ($validated) {
            $roleIds = $validated['roles'] ?? [];
            unset($validated['roles']);

            $permission = $this->permissionRepository->create($validated);
            $permission->syncRoles($roleIds);

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $permission->refresh();
        });
    }

    public function update(Permission $permission, array $validated): Permission
    {
        return DB::transaction(function () use ($permission, $validated) {
            $roleIds = $validated['roles'] ?? [];
            unset($validated['roles']);

            $updatedPermission = $this->permissionRepository->update($permission, $validated);
            $updatedPermission->syncRoles($roleIds);

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $updatedPermission->refresh();
        });
    }

    public function delete(Permission $permission): void
    {
        $permission->loadCount(['roles', 'users']);

        if ($permission->roles_count > 0 || $permission->users_count > 0) {
            throw ValidationException::withMessages([
                'permission' => 'Permission tidak bisa dihapus karena masih dipakai role atau user.',
            ]);
        }

        $this->permissionRepository->delete($permission);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
