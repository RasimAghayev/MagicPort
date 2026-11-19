<?php

namespace App\Repositories\V1\Company;

use App\Models\V1\Company;
use App\Repositories\V1\RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface CompanyRepositoryInterface extends RepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Company;

    public function create(array $data): Company;

    public function update(Company $company, array $data): Company;

    public function delete(Company $company): bool;

    public function restore(string $code): ?Company;

    public function forceDelete(string $code): bool;
}
