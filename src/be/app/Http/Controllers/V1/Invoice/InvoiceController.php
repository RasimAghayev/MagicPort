<?php

namespace App\Http\Controllers\V1\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Invoice\StoreInvoiceRequest;
use App\Http\Requests\V1\Invoice\UpdateInvoiceRequest;
use App\Http\Resources\V1\Invoice\InvoiceCollection;
use App\Http\Resources\V1\Invoice\InvoiceResource;
use App\Services\V1\Invoice\InvoiceServiceInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceServiceInterface $service
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'company_code', 'search']);
        $perPage = (int) $request->query('perPage', 15);

        return new InvoiceCollection($this->service->all($filters, $perPage));
    }

    public function store(StoreInvoiceRequest $request)
    {
        $invoice = $this->service->create($request->validated());

        return $this->respondCreated(
            new InvoiceResource($invoice),
            'Invoice created successfully.'
        );
    }

    public function show(string $code)
    {
        $invoice = $this->service->findByCode($code);
        if (!$invoice) {
            return $this->respondError('Invoice not found.', 404);
        }

        return $this->respond(
            new InvoiceResource($invoice),
            'Invoice retrieved successfully.'
        );
    }

    public function update(UpdateInvoiceRequest $request, string $code)
    {
        $invoice = $this->service->update($code, $request->validated());

        return $this->respond(
            new InvoiceResource($invoice),
            'Invoice updated successfully.'
        );
    }

    public function destroy(string $code)
    {
        $deleted = $this->service->delete($code);
        if (!$deleted) {
            return $this->respondError('Invoice not found.', 404);
        }

        return $this->respondDeleted('Invoice deleted successfully.');
    }

    public function restore(string $code)
    {
        $invoice = $this->service->restore($code);
        if (!$invoice) {
            return $this->respondError('Invoice not found.', 404);
        }

        return $this->respond(
            new InvoiceResource($invoice),
            'Invoice restored successfully.'
        );
    }

    public function forceDelete(string $code)
    {
        $deleted = $this->service->forceDelete($code);
        if (!$deleted) {
            return $this->respondError('Invoice not found.', 404);
        }

        return $this->respondDeleted('Invoice permanently deleted.');
    }
}
