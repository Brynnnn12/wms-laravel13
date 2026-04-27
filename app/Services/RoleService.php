<?php

namespace App\Services;

use App\Models\Permission;
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

    public function permissionsByGuard(): \Illuminate\Support\Collection
    {
        // Pastikan di RoleRepository ada method permissions() yang mengambil semua permission
        return $this->roleRepository->permissions()->groupBy('guard_name');
    }

    public function create(array $validated): Role
    {
        return DB::transaction(function () use ($validated) {
            $permissionIds = $validated['permissions'] ?? [];
            unset($validated['permissions']);

            $role = $this->roleRepository->create($validated);
            $permissionNames = $this->roleRepository->permissionNamesByIds($permissionIds, $role->guard_name);
            $role->syncPermissions($permissionNames);

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $role->refresh();
        });
    }

    // app/Services/RoleService.php

    public function update(Role $role, array $validated): Role
    {
        return DB::transaction(function () use ($role, $validated) {
            $role->update([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'],
            ]);

            // AMBIL nama permission HANYA yang guard-nya sama dengan guard role ini
            $validPermissions = Permission::whereIn('id', $validated['permissions'] ?? [])
                ->where('guard_name', $validated['guard_name'])
                ->pluck('name')
                ->toArray();

            $role->syncPermissions($validPermissions);

            return $role;
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
