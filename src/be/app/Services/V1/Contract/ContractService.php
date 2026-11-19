<?php

namespace App\Services\V1\Contract;

use App\Models\V1\Contract;
use App\Repositories\V1\Contract\ContractRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class ContractService implements ContractServiceInterface
{
    public function __construct(
        protected ContractRepositoryInterface $repository
    ) {}

    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->all($filters, $perPage);
    }

    public function findByCode(string $code): ?Contract
    {
        return $this->repository->findByCode($code);
    }

    public function create(array $data): Contract
    {
        return $this->repository->create($data);
    }

    public function update(string $code, array $data): Contract
    {
        $contract = $this->repository->findByCode($code);
        if (!$contract) {
            throw new ModelNotFoundException("Contract with code {$code} not found.");
        }
        return $this->repository->update($contract, $data);
    }

    public function delete(string $code): bool
    {
        $contract = $this->repository->findByCode($code);
        if (!$contract) {
            return false;
        }
        return $this->repository->delete($contract);
    }

    public function restore(string $code): ?Contract
    {
        return $this->repository->restore($code);
    }

    public function forceDelete(string $code): bool
    {
        return $this->repository->forceDelete($code);
    }
}
