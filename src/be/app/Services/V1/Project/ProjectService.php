<?php

namespace App\Services\V1\Project;

use App\Models\V1\Project;
use App\Repositories\V1\Project\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService implements ProjectServiceInterface
{
    public function __construct(
        protected ProjectRepositoryInterface $repository
    ) {}

    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->all($filters, $perPage);
    }

    public function findByCode(string $code): ?Project
    {
        return $this->repository->findByCode($code);
    }

    public function create(array $data): Project
    {
        return $this->repository->create($data);
    }

    public function update(string $code, array $data): Project
    {
        $project = $this->repository->findByCode($code);
        if (!$project) {
            throw new ModelNotFoundException("Project with code {$code} not found.");
        }
        return $this->repository->update($project, $data);
    }

    public function delete(string $code): bool
    {
        $project = $this->repository->findByCode($code);
        if (!$project) {
            return false;
        }
        return $this->repository->delete($project);
    }

    public function restore(string $code): ?Project
    {
        return $this->repository->restore($code);
    }

    public function forceDelete(string $code): bool
    {
        return $this->repository->forceDelete($code);
    }
}
