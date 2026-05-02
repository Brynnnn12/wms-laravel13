<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private readonly User $model
    )
    {
        //
    }


    public function findByEmail(string $email) : ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function paginate(int $perPage = 10)
    {
        return $this->model->paginate($perPage);
    }
    public function create(array $data) : User
    {
        return $this->model->create($data);
    }

    public function update(User $user, array $data) : User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user) : bool
    {
        return $user->delete();
    }

    public function bulkDelete(array $ids) : int
    {
        return $this->model->whereIn('id', $ids)->delete();
    }
}
