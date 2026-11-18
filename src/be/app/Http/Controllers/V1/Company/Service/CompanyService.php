<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Service;

use App\Http\Controllers\V1\Company\DTO\CompanyDTO;
use App\Http\Controllers\V1\Company\Filter\CompanyFilters;
use App\Http\Controllers\V1\Company\Repository\CompanyRepositoryInterface;
use App\Http\Controllers\V1\Company\Resources\CompanyCollection;
use App\Models\V1\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CompanyService implements CompanyServiceInterface
{
    public function __construct(
        protected CompanyRepositoryInterface $companyRepositoryInterface
    ){}

    /**
     * @param Request $request
     * @param bool $includeTasks
     * @param int $perPage
     * @return CompanyCollection
     */
    public function getCompanies(Request $request,
                                 ?bool    $includeTasks,
                                 int     $perPage):CompanyCollection
    {
        $includeTasks = $includeTasks ?? false;
        $filter = new CompanyFilters();
        $queryItems = $filter->transform(request: $request);

        return $this->companyRepositoryInterface
            ->getFilteredCompanies(
                queryItems: $queryItems,
                includeTasks: $includeTasks,
                perPage: $perPage
            );
    }

    public function findByUserId(int $userId): Company|Collection|null
    {
        return $this->companyRepositoryInterface->findByUserId($userId);
    }

    public function findById(int $id): ?Company
    {
        return $this->companyRepositoryInterface->find($id);
    }

    public function create(CompanyDTO $dto): Company
    {
        return $this->companyRepositoryInterface->create([
            'user_id' => $dto->userId,
            'name' => $dto->name,
            'status' => $dto->status,
        ]);
    }

    public function update(int $id, CompanyDTO $dto): Company
    {
        return $this->companyRepositoryInterface->update($id, [
            'user_id' => $dto->userId,
            'name' => $dto->name,
            'status' => $dto->status,
        ]);
    }

    public function deleteById(int $id): bool
    {
        $this->companyRepositoryInterface->delete($id);
        return true;
    }
}
