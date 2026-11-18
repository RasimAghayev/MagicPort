<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Repository;

use App\Http\Controllers\V1\Company\Resources\CompanyCollection;
use App\Models\V1\Company;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @param Company $companyModel
     */
    public function __construct(
        protected Company $companyModel
    ){}

    public function getFilteredCompanies(array $queryItems,
                                         ?bool  $includeTasks,
                                         int   $perPage): CompanyCollection
    {
        $company = $this->companyModel->where($queryItems);

        $includeTasks = $includeTasks ?? false;

        if ($includeTasks) {
            $company = $company->with(['users','projects','tasks']);
        }

        $maxPerPage = 100;
        $perPage = min($perPage, $maxPerPage);

        return new CompanyCollection(
            $company->orderBy('id', 'desc')
                ->paginate($perPage)
                ->appends(request()->query())
        );
    }

    public function all(): ?Collection
    {
        return $this->companyModel->all();
    }

    public function find(int $id): ?Company
    {
        return $this->companyModel->find($id);
    }

    public function findByUserId(int $userId): Company|Collection|null
    {
        $results = $this->companyModel->where('user_id', $userId)->get();
        return $results->count() > 1 ? $results : $results->first();
    }

    public function create(array $companyData): Company
    {
        return $this->companyModel->create($companyData);
    }

    public function update(int $id, array $data): Company
    {
        $company = $this->find($id);
        if (!$company) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
        }
        $company->update($data);
        return $company;
    }

    public function delete(int $id): bool
    {
        return $this->companyModel->destroy($id) > 0;
    }

    public function deleteById(int $id): void
    {
        $this->delete($id);
    }
}
