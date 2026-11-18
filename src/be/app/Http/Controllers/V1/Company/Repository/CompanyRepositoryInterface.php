<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Repository;

use App\Http\Controllers\V1\Company\Resources\CompanyCollection;
use App\Models\V1\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    public function getFilteredCompanies(array $queryItems,
                                         ?bool $includeTasks,
                                         int   $perPage): CompanyCollection;
    public function all(): ?Collection;
    public function find(int $id): ?Company;
    public function findByUserId(int $userId): Company|Collection|null;
    public function create(array $companyData): Company;
    public function update(int $id, array $data): Company;
    public function delete(int $id): bool;
    public function deleteById(int $id): void;
}
