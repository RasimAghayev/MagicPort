<?php

namespace App\Repositories\V1\Contract;

use App\Models\V1\Contract;
use App\Repositories\V1\RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface ContractRepositoryInterface extends RepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Contract;

    public function create(array $data): Contract;

    public function update(Contract $contract, array $data): Contract;

    public function delete(Contract $contract): bool;

    public function restore(string $code): ?Contract;

    public function forceDelete(string $code): bool;
}
