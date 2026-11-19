<?php

namespace App\Repositories\V1\Company;

use App\Models\V1\Company;
use App\Repositories\V1\RepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Company::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['with_tasks']) && $filters['with_tasks']) {
            $query->with('tasks');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): ?Company
    {
        return Company::find($id);
    }

    public function findOrFail(int $id): Company
    {
        return Company::findOrFail($id);
    }

    public function findByCode(string $code): ?Company
    {
        return Company::where('code', $code)->first();
    }

    public function create(array $data): Company
    {
        return Company::create($data);
    }

    public function update(Company $company, array $data): Company
    {
        $company->update($data);
        return $company->fresh();
    }

    public function delete(Company $company): bool
    {
        return $company->delete();
    }

    public function restore(string $code): ?Company
    {
        $company = Company::withTrashed()->where('code', $code)->first();
        if (!$company) {
            return null;
        }
        $company->restore();
        return $company->fresh();
    }

    public function forceDelete(string $code): bool
    {
        $company = Company::withTrashed()->where('code', $code)->first();
        if (!$company) {
            return false;
        }
        return $company->forceDelete();
    }
}
