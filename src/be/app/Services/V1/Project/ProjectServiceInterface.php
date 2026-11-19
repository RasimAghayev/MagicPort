<?php

namespace App\Services\V1\Project;

use App\Models\V1\Project;
use App\Repositories\V1\Project\ProjectRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProjectServiceInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Project;

    public function create(array $data): Project;

    public function update(string $code, array $data): Project;

    public function delete(string $code): bool;

    public function restore(string $code): ?Project;

    public function forceDelete(string $code): bool;
}
