<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\PermissionRegistrar;

class RoleService
{
    public function __construct(
        private readonly RoleRepository $roleRepository,
    ) {
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->roleRepository->paginate($perPage);
    }

    public function permissions(): Collection
    {
        return $this->roleRepository->permissions();
    }

    public function create(array $validated): Role
    {
        return DB::transaction(function () use ($validated) {
            $permissionIds = $validated['permissions'] ?? [];
            unset($validated['permissions']);

            $role = $this->roleRepository->create($validated);
            $role->syncPermissions($permissionIds);

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $role->refresh();
        });
    }

    public function update(Role $role, array $validated): Role
    {
        return DB::transaction(function () use ($role, $validated) {
            $permissionIds = $validated['permissions'] ?? [];
            unset($validated['permissions']);

            $updatedRole = $this->roleRepository->update($role, $validated);
            $updatedRole->syncPermissions($permissionIds);

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $updatedRole->refresh();
        });
    }

    public function delete(Role $role): void
    {
        $role->loadCount('users');

        if ($role->users_count > 0) {
            throw ValidationException::withMessages([
                'role' => 'Role tidak bisa dihapus karena masih dipakai oleh user.',
            ]);
        }

        $this->roleRepository->delete($role);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
