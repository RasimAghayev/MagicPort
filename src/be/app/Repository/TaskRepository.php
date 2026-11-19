<?php

namespace App\Repository;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function index($search = null, $perPage = 15)
    {
        $query = Task::query()->with(['company', 'project', 'user']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('name')->paginate((int) $perPage);
    }

    public function getByCode(string $code)
    {
        return Task::where('code', $code)->firstOrFail();
    }

    public function store(array $data)
    {
        return Task::create($data);
    }

    public function update(array $data, string $code)
    {
        $task = Task::where('code', $code)->firstOrFail();
        $task->update($data);
        return $task;
    }

    public function delete(string $code)
    {
        $task = Task::where('code', $code)->firstOrFail();
        return $task->delete();
    }

    public function restore(string $code)
    {
        $task = Task::withTrashed()->where('code', $code)->firstOrFail();
        return $task->restore();
    }

    public function forceDelete(string $code)
    {
        $task = Task::withTrashed()->where('code', $code)->firstOrFail();
        return $task->forceDelete();
    }
}
