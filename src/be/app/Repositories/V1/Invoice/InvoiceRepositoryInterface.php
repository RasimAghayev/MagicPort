<?php

namespace App\Repositories\V1\Invoice;

use App\Models\V1\Invoice;
use App\Repositories\V1\RepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

interface InvoiceRepositoryInterface extends RepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findByCode(string $code): ?Invoice;

    public function create(array $data): Invoice;

    public function update(Invoice $invoice, array $data): Invoice;

    public function delete(Invoice $invoice): bool;

    public function restore(string $code): ?Invoice;

    public function forceDelete(string $code): bool;
}
