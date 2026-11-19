<?php

namespace App\Services\V1\Company;

use App\Models\V1\Company;
use App\Repositories\V1\Company\CompanyRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyService implements CompanyServiceInterface
{
    public function __construct(
        protected CompanyRepositoryInterface $repository
    ) {}

    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->all($filters, $perPage);
    }

    public function findByCode(string $code): ?Company
    {
        return $this->repository->findByCode($code);
    }

    public function create(array $data): Company
    {
        return $this->repository->create($data);
    }

    public function update(string $code, array $data): Company
    {
        $company = $this->repository->findByCode($code);
        if (!$company) {
            throw new ModelNotFoundException("Company with code {$code} not found.");
        }
        return $this->repository->update($company, $data);
    }

    public function delete(string $code): bool
    {
        $company = $this->repository->findByCode($code);
        if (!$company) {
            return false;
        }
        return $this->repository->delete($company);
    }

    public function restore(string $code): ?Company
    {
        return $this->repository->restore($code);
    }

    public function forceDelete(string $code): bool
    {
        return $this->repository->forceDelete($code);
    }
}
