<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Service;

use App\Http\Controllers\V1\Company\DTO\CompanyDTO;
use App\Http\Controllers\V1\Company\Resources\CompanyCollection;
use App\Models\V1\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface CompanyServiceInterface
{
    /**
     * @param Request $request
     * @param bool $includeTasks
     * @param int $perPage
     * @return CompanyCollection
     */
    public function getCompanies(Request $request,
                                 ?bool    $includeTasks,
                                 int     $perPage): CompanyCollection;
    public function findByUserId(int $userId): Company|Collection|null;
    public function findById(int $id): ?Company;
    public function create(CompanyDTO $dto): Company;
    public function update(int $id, CompanyDTO $dto): Company;
    public function deleteById(int $id): bool;
}
