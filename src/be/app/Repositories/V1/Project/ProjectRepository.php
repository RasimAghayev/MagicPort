<?php

namespace App\Repositories\V1\Project;

use App\Models\V1\Project;
use App\Repositories\V1\RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Project::query()->with('tasks');

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['company_id'])) {
            $query->where('company_id', $filters['company_id']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): ?Project
    {
        return Project::find($id);
    }

    public function findOrFail(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function findByCode(string $code): ?Project
    {
        return Project::where('code', $code)->first();
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);
        return $project->fresh();
    }

    public function delete(Project $project): bool
    {
        return $project->delete();
    }

    public function restore(string $code): ?Project
    {
        $project = Project::withTrashed()->where('code', $code)->first();
        if (!$project) {
            return null;
        }
        $project->restore();
        return $project->fresh();
    }

    public function forceDelete(string $code): bool
    {
        $project = Project::withTrashed()->where('code', $code)->first();
        if (!$project) {
            return false;
        }
        return $project->forceDelete();
    }
}
