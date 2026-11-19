<?php

namespace App\Http\Controllers\V1\Contract;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Contract\StoreContractRequest;
use App\Http\Requests\V1\Contract\UpdateContractRequest;
use App\Http\Resources\V1\Contract\ContractCollection;
use App\Http\Resources\V1\Contract\ContractResource;
use App\Services\V1\Contract\ContractServiceInterface;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function __construct(
        protected ContractServiceInterface $service
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'company_code', 'search']);
        $perPage = (int) $request->query('perPage', 15);

        return new ContractCollection($this->service->all($filters, $perPage));
    }

    public function store(StoreContractRequest $request)
    {
        $contract = $this->service->create($request->validated());

        return $this->respondCreated(
            new ContractResource($contract),
            'Contract created successfully.'
        );
    }

    public function show(string $code)
    {
        $contract = $this->service->findByCode($code);
        if (!$contract) {
            return $this->respondError('Contract not found.', 404);
        }

        return $this->respond(
            new ContractResource($contract),
            'Contract retrieved successfully.'
        );
    }

    public function update(UpdateContractRequest $request, string $code)
    {
        $contract = $this->service->update($code, $request->validated());

        return $this->respond(
            new ContractResource($contract),
            'Contract updated successfully.'
        );
    }

    public function destroy(string $code)
    {
        $deleted = $this->service->delete($code);
        if (!$deleted) {
            return $this->respondError('Contract not found.', 404);
        }

        return $this->respondDeleted('Contract deleted successfully.');
    }

    public function restore(string $code)
    {
        $contract = $this->service->restore($code);
        if (!$contract) {
            return $this->respondError('Contract not found.', 404);
        }

        return $this->respond(
            new ContractResource($contract),
            'Contract restored successfully.'
        );
    }

    public function forceDelete(string $code)
    {
        $deleted = $this->service->forceDelete($code);
        if (!$deleted) {
            return $this->respondError('Contract not found.', 404);
        }

        return $this->respondDeleted('Contract permanently deleted.');
    }
}
