<?php

namespace App\Repositories\V1\Invoice;

use App\Models\V1\Invoice;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Invoice::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['company_code'])) {
            $query->where('company_code', $filters['company_code']);
        }

        if (!empty($filters['search'])) {
            $query->where('invoice_number', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function findById(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function findOrFail(int $id): Invoice
    {
        return Invoice::findOrFail($id);
    }

    public function findByCode(string $code): ?Invoice
    {
        return Invoice::where('code', $code)->first();
    }

    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function update(Invoice $invoice, array $data): Invoice
    {
        $invoice->update($data);
        return $invoice->fresh();
    }

    public function delete(Invoice $invoice): bool
    {
        return $invoice->delete();
    }

    public function restore(string $code): ?Invoice
    {
        $invoice = Invoice::withTrashed()->where('code', $code)->first();
        if (!$invoice || $invoice->deleted_at === null) {
            return null;
        }
        $invoice->restore();
        return $invoice->fresh();
    }

    public function forceDelete(string $code): bool
    {
        $invoice = Invoice::withTrashed()->where('code', $code)->first();
        if (!$invoice) {
            return false;
        }
        return $invoice->forceDelete();
    }
}
