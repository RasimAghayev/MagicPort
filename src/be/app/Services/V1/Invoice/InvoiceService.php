<?php

namespace App\Services\V1\Invoice;

use App\Models\V1\Invoice;
use App\Repositories\V1\Invoice\InvoiceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceService implements InvoiceServiceInterface
{
    public function __construct(
        protected InvoiceRepositoryInterface $repository
    ) {}

    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->all($filters, $perPage);
    }

    public function findByCode(string $code): ?Invoice
    {
        return $this->repository->findByCode($code);
    }

    public function create(array $data): Invoice
    {
        return $this->repository->create($data);
    }

    public function update(string $code, array $data): Invoice
    {
        $invoice = $this->repository->findByCode($code);
        if (!$invoice) {
            throw new ModelNotFoundException("Invoice with code {$code} not found.");
        }
        return $this->repository->update($invoice, $data);
    }

    public function delete(string $code): bool
    {
        $invoice = $this->repository->findByCode($code);
        if (!$invoice) {
            return false;
        }
        return $this->repository->delete($invoice);
    }

    public function restore(string $code): ?Invoice
    {
        return $this->repository->restore($code);
    }

    public function forceDelete(string $code): bool
    {
        return $this->repository->forceDelete($code);
    }
}
