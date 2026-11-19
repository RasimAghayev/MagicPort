<?php

namespace App\Services\V1\Contract;

use App\Models\V1\Contract;
use App\Repositories\V1\Contract\ContractRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

interface ContractServiceInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Contract;

    public function create(array $data): Contract;

    public function update(string $code, array $data): Contract;

    public function delete(string $code): bool;

    public function restore(string $code): ?Contract;

    public function forceDelete(string $code): bool;
}
