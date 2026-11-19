<?php

namespace App\Services\V1\User;

use App\Models\User;
use App\Repositories\V1\User\UserRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserServiceInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByEmail(string $email): ?User;

    public function create(array $data): User;

    public function update(int $id, array $data): User;

    public function delete(int $id): bool;

    public function restore(int $id): ?User;

    public function forceDelete(int $id): bool;
}
