<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Repository;

use App\Http\Controllers\V1\Company\Resources\CompanyCollection;

interface CompanyRepositoryInterface
{
    public function getFilteredCompanies(array $queryItems,
                                         ?bool $includeTasks,
                                         int   $perPage): CompanyCollection;
//    public function all(): ?Collection;
//    public function find(int $id): ?Company;
//    public function findByUserId(User $user): Company;
//    public function create(Company $phone): Company;
//    public function deleteById(int $id): void;
}