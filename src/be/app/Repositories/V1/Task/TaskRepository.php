<?php

namespace App\Repositories\V1\Task;

use App\Models\V1\Task;
use App\Repositories\V1\RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Task::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['project_id'])) {
            $query->where('project_id', $filters['project_id']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): ?Task
    {
        return Task::find($id);
    }

    public function findOrFail(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function findByCode(string $code): ?Task
    {
        return Task::where('code', $code)->first();
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->fresh();
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    public function restore(string $code): ?Task
    {
        $task = Task::withTrashed()->where('code', $code)->first();
        if (!$task) {
            return null;
        }
        $task->restore();
        return $task->fresh();
    }

    public function forceDelete(string $code): bool
    {
        $task = Task::withTrashed()->where('code', $code)->first();
        if (!$task) {
            return false;
        }
        return $task->forceDelete();
    }
}
