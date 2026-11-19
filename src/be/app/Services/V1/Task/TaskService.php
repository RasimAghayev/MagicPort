<?php

namespace App\Services\V1\Task;

use App\Models\V1\Task;
use App\Repositories\V1\Task\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService implements TaskServiceInterface
{
    public function __construct(
        protected TaskRepositoryInterface $repository
    ) {}

    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->all($filters, $perPage);
    }

    public function findByCode(string $code): ?Task
    {
        return $this->repository->findByCode($code);
    }

    public function create(array $data): Task
    {
        return $this->repository->create($data);
    }

    public function update(string $code, array $data): Task
    {
        $task = $this->repository->findByCode($code);
        if (!$task) {
            throw new ModelNotFoundException("Task with code {$code} not found.");
        }
        return $this->repository->update($task, $data);
    }

    public function delete(string $code): bool
    {
        $task = $this->repository->findByCode($code);
        if (!$task) {
            return false;
        }
        return $this->repository->delete($task);
    }

    public function restore(string $code): ?Task
    {
        return $this->repository->restore($code);
    }

    public function forceDelete(string $code): bool
    {
        return $this->repository->forceDelete($code);
    }
}
