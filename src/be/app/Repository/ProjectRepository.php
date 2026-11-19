<?php

namespace App\Repository;

use App\Interfaces\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function index($search = null, $perPage = 15)
    {
        $query = Project::query()->with('company');

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
        return Project::where('code', $code)->firstOrFail();
    }

    public function store(array $data)
    {
        return Project::create($data);
    }

    public function update(array $data, string $code)
    {
        $project = Project::where('code', $code)->firstOrFail();
        $project->update($data);
        return $project;
    }

    public function delete(string $code)
    {
        $project = Project::where('code', $code)->firstOrFail();
        return $project->delete();
    }

    public function restore(string $code)
    {
        $project = Project::withTrashed()->where('code', $code)->firstOrFail();
        return $project->restore();
    }

    public function forceDelete(string $code)
    {
        $project = Project::withTrashed()->where('code', $code)->firstOrFail();
        return $project->forceDelete();
    }
}
