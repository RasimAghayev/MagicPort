<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Service;

use App\Http\Controllers\V1\Company\Filter\CompanyFilters;
use App\Http\Controllers\V1\Company\Repository\CompanyRepository;
use App\Http\Controllers\V1\Company\Repository\CompanyRepositoryInterface;
use App\Http\Controllers\V1\Company\Resources\CompanyCollection;
use App\Models\User;
use App\Models\V1\Company;
use Illuminate\Http\Request;

class CompanyService implements CompanyServiceInterface
{
    public function __construct(
        protected CompanyRepositoryInterface $companyRepositoryInterface
    ){}

    /**
     * @param Request $request
     * @param bool $includeOrder
     * @param int $perPage
     * @return mixed
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

//    public function findByUserId(User $user): Company
//    {
//        // TODO: Implement findByUserId() method.
//    }
//
//    public function findByCompanyId(User $phone): Company
//    {
//        // TODO: Implement findByCompanyId() method.
//    }
//
//    public function create(string $name, Phone $phone): Company
//    {
//        // TODO: Implement create() method.
//    }
//
//    public function deleteById(int $id): void
//    {
//        // TODO: Implement deleteById() method.
//    }
}
