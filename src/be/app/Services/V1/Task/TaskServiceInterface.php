<?php

namespace App\Services\V1\Task;

use App\Models\V1\Task;
use App\Repositories\V1\Task\TaskRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskServiceInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Task;

    public function create(array $data): Task;

    public function update(string $code, array $data): Task;

    public function delete(string $code): bool;

    public function restore(string $code): ?Task;

    public function forceDelete(string $code): bool;
}
