<?php

namespace App\Services\V1\User;

use App\Models\User;
use App\Repositories\V1\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->all($filters, $perPage);
    }

    public function findById(int $id): ?User
    {
        return $this->repository->findById($id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findByEmail($email);
    }

    public function create(array $data): User
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): User
    {
        $user = $this->repository->findById($id);
        if (!$user) {
            throw new ModelNotFoundException("User with ID {$id} not found.");
        }
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        return $this->repository->update($user, $data);
    }

    public function delete(int $id): bool
    {
        $user = $this->repository->findById($id);
        if (!$user) {
            return false;
        }
        return $this->repository->delete($user);
    }

    public function restore(int $id): ?User
    {
        return $this->repository->restore($id);
    }

    public function forceDelete(int $id): bool
    {
        return $this->repository->forceDelete($id);
    }
}
