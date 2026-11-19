<?php

namespace App\Services\V1\Company;

use App\Models\V1\Company;
use App\Repositories\V1\Company\CompanyRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface CompanyServiceInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Company;

    public function create(array $data): Company;

    public function update(string $code, array $data): Company;

    public function delete(string $code): bool;

    public function restore(string $code): ?Company;

    public function forceDelete(string $code): bool;
}
