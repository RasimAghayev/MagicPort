<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Repository;

use App\Http\Controllers\V1\Company\Resources\CompanyCollection;
use App\Http\Controllers\V1\Project\Requests\StoreProjectRequest;
use App\Http\Controllers\V1\Project\Resources\ProjectResource;
use App\Models\User;
use App\Models\V1\Company;
use App\Models\V1\Project;
use Illuminate\Database\Eloquent\Collection;

class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * @param Company $companyModel
     */
    public function __construct(
        protected Company $companyModel
    ){}

    /**
     * @param StoreProjectRequest $request
     * @return ProjectResource
     */
    private function getValidateData($request, $id = null): array
    {
        $validateData = [
            [
                'model' => User::class,
                'request' => ['id' => $request->userId],
                'message' => 'User'
            ],
        ];
        if (!is_null($id)) {
            $validateProjectData = [
                [
                    'model' => Company::class,
                    'request' => ['id' => $request->companyId],
                    'message' => 'Company'
                ],
                [
                    'model' => Company::class,
                    'request' => ['id' => $request->companyId, 'user_id' => $request->userId],
                    'message' => 'Company'
                ]
            ];
        }
        return array_merge($validateData, $validateProjectData);
    }
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


    /**
     * @return ?Collection
     */
//    public function all(): ?Collection
//    {
//        return $this->companyModel->all();
//    }
//
//    /**
//     * @param int $id
//     * @return Company|null
//     */
//    public function find(int $id): ?Company
//    {
//        return $this->companyModel->findOrFail($id);
//    }
//
//    /**
//     * @param $userId
//     * @return Company|Collection|null
//     */
//    public function findByUserId($userId): Company|Collection|null
//    {
//        $results=$this->companyModel->where('user_id', $userId)->get();
//        return $results->count() > 1 ? $results : $results->first();
//    }
//
//    /**
//     * @param array $companyData
//     * @return Company
//     */
//    public function createCompany(array $companyData): Company
//    {
//        return $this->companyModel->create($companyData);
//    }
//
//    /**
//     * @param int $id
//     * @param array $data
//     * @return Company
//     */
//    public function update(int $id, array $data): Company
//    {
//        $company = $this->find($id);
//        $company?->update($data);
//        return $company;
//    }
//
//    /**
//     * @param int $id
//     * @return bool
//     */
//    public function delete(int $id): bool
//    {
//        return $this->companyModel->destroy($id) > 0;
//    }
//
//    public function create(Company $phone): Company
//    {
//        // TODO: Implement create() method.
//    }
//
//    public function deleteById(int $id): void
//    {
//        // TODO: Implement deleteById() method.
//    }
}