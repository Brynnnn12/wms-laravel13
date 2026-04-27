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

    /**
     * Mengambil data permission dengan paginasi.
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->permissionRepository->paginate($perPage);
    }

    /**
     * Mengambil semua role yang dikelompokkan berdasarkan guard_name.
     * Digunakan untuk tampilan Blade tanpa JavaScript.
     */
    public function rolesByGuard(): \Illuminate\Support\Collection
    {
        return $this->permissionRepository->roles()->groupBy('guard_name');
    }

    /**
     * Membuat permission baru dan menyinkronkan dengan role yang valid.
     */
    public function create(array $validated): Permission
    {
        return DB::transaction(function () use ($validated) {
            $roleIds = $validated['roles'] ?? [];

            // 1. Buat Permission
            $permission = $this->permissionRepository->create([
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'],
            ]);

            // 2. Ambil nama role yang HANYA sesuai dengan guard permission ini
            $roleNames = $this->permissionRepository->roleNamesByIds($roleIds, $permission->guard_name);

            // 3. Sinkronisasi (Spatie syncRoles)
            $permission->syncRoles($roleNames);

            // 4. Bersihkan Cache Spatie agar perubahan langsung terasa
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $permission->refresh();
        });
    }

    /**
     * Memperbarui permission dan menyinkronkan ulang role yang valid.
     */
    public function update(Permission $permission, array $validated): Permission
    {
        return DB::transaction(function () use ($permission, $validated) {
            $roleIds = $validated['roles'] ?? [];

            // 1. Update data dasar permission
            $updatedPermission = $this->permissionRepository->update($permission, [
                'name' => $validated['name'],
                'guard_name' => $validated['guard_name'],
            ]);

            // 2. Ambil nama role yang valid (mencegah GuardMismatch)
            $roleNames = $this->permissionRepository->roleNamesByIds($roleIds, $updatedPermission->guard_name);

            // 3. Sinkronisasi ulang
            $updatedPermission->syncRoles($roleNames);

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $updatedPermission->refresh();
        });
    }

    /**
     * Menghapus permission dengan pengecekan relasi.
     */
    public function delete(Permission $permission): void
    {
        // Load count untuk mengecek apakah permission masih digunakan
        $permission->loadCount(['roles', 'users']);

        if ($permission->roles_count > 0 || $permission->users_count > 0) {
            throw ValidationException::withMessages([
                'permission' => 'Gagal menghapus! Permission ini masih terikat pada ' . $permission->roles_count . ' Role dan ' . $permission->users_count . ' User.',
            ]);
        }

        $this->permissionRepository->delete($permission);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
