<?php

namespace App\Repository;

use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function index($search = null, $perPage = 15)
    {
        $query = Company::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('name')->paginate((int) $perPage);
    }

    public function getByCode(string $code)
    {
        return Company::where('code', $code)->firstOrFail();
    }

    public function store(array $data)
    {
        return Company::create($data);
    }

    public function update(array $data, string $code)
    {
        $company = Company::where('code', $code)->firstOrFail();
        $company->update($data);
        return $company;
    }

    public function delete(string $code)
    {
        $company = Company::where('code', $code)->firstOrFail();
        return $company->delete();
    }

    public function restore(string $code)
    {
        $company = Company::withTrashed()->where('code', $code)->firstOrFail();
        return $company->restore();
    }

    public function forceDelete(string $code)
    {
        $company = Company::withTrashed()->where('code', $code)->firstOrFail();
        return $company->forceDelete();
    }
}
