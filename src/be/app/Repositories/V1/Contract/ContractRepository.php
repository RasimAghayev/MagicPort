<?php

namespace App\Repositories\V1\Contract;

use App\Models\V1\Contract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class ContractRepository implements ContractRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Contract::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['company_code'])) {
            $query->where('company_code', $filters['company_code']);
        }

        if (!empty($filters['search'])) {
            $query->where('contract_number', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): ?Contract
    {
        return Contract::find($id);
    }

    public function findOrFail(int $id): Contract
    {
        return Contract::findOrFail($id);
    }

    public function findByCode(string $code): ?Contract
    {
        return Contract::where('code', $code)->first();
    }

    public function create(array $data): Contract
    {
        return Contract::create($data);
    }

    public function update(Contract $contract, array $data): Contract
    {
        $contract->update($data);
        return $contract->fresh();
    }

    public function delete(Contract $contract): bool
    {
        return $contract->delete();
    }

    public function restore(string $code): ?Contract
    {
        $contract = Contract::withTrashed()->where('code', $code)->first();
        if (!$contract || $contract->deleted_at === null) {
            return null;
        }
        $contract->restore();
        return $contract->fresh();
    }

    public function forceDelete(string $code): bool
    {
        $contract = Contract::withTrashed()->where('code', $code)->first();
        if (!$contract) {
            return false;
        }
        return $contract->forceDelete();
    }
}
