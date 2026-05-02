<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private readonly UserRepository $repository
    ) {
    }

    public function paginate(int $perPage = 10)
    {
        return $this->repository->paginate($perPage);
    }

    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $roles = $data['roles'] ?? [];
            unset($data['roles']);

            if (! empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user = $this->repository->create($data);

            if (! empty($roles)) {
                $user->syncRoles($roles);
            }

            return $user;
        });
    }

    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $roles = $data['roles'] ?? [];
            unset($data['roles']);

            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }

            $updatedUser = $this->repository->update($user, $data);

            $updatedUser->syncRoles($roles);

            return $updatedUser;
        });
    }

    public function delete(User $user): bool
    {
        if ($user->is_active) {
            throw new DomainException('User aktif tidak dapat dihapus.');
        }

        return $this->repository->delete($user);
    }

    public function bulkDelete(array $ids): int
    {
        return DB::transaction(function () use ($ids) {
            $activeUsersCount = User::whereIn('id', $ids)
                ->where('is_active', true)
                ->count();

            if ($activeUsersCount > 0) {
                throw new DomainException(
                    'Terdapat user aktif dalam pilihan. Nonaktifkan terlebih dahulu.'
                );
            }

            return $this->repository->bulkDelete($ids);
        });
    }
}
