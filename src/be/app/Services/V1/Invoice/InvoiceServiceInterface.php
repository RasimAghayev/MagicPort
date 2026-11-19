<?php

namespace App\Services\V1\Invoice;

use App\Models\V1\Invoice;
use App\Repositories\V1\Invoice\InvoiceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

interface InvoiceServiceInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Invoice;

    public function create(array $data): Invoice;

    public function update(string $code, array $data): Invoice;

    public function delete(string $code): bool;

    public function restore(string $code): ?Invoice;

    public function forceDelete(string $code): bool;
}
