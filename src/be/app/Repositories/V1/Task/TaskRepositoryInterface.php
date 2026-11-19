<?php

namespace App\Repositories\V1\Task;

use App\Models\V1\Task;
use App\Repositories\V1\RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface extends RepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Task;

    public function create(array $data): Task;

    public function update(Task $task, array $data): Task;

    public function delete(Task $task): bool;

    public function restore(string $code): ?Task;

    public function forceDelete(string $code): bool;
}
