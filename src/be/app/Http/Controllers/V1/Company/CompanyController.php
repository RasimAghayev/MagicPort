<?php

namespace App\Http\Controllers\V1\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Company\StoreCompanyRequest;
use App\Http\Requests\V1\Company\UpdateCompanyRequest;
use App\Http\Resources\V1\Company\CompanyCollection;
use App\Http\Resources\V1\Company\CompanyResource;
use App\Services\V1\Company\CompanyServiceInterface;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyServiceInterface $service
    ) {}

    public function index(Request $request): CompanyCollection
    {
        $filters = $request->only(['status', 'search', 'with_tasks']);
        $perPage = (int) $request->query('perPage', 15);

        return $this->respond(
            new CompanyCollection($this->service->all($filters, $perPage)),
            'Companies retrieved successfully.'
        );
    }

    public function store(StoreCompanyRequest $request): CompanyResource
    {
        $company = $this->service->create($request->validated());

        return $this->respondCreated(
            new CompanyResource($company),
            'Company created successfully.'
        );
    }

    public function show(string $code): CompanyResource
    {
        $company = $this->service->findByCode($code);
        if (!$company) {
            return $this->respondError('Company not found.', 404);
        }

        return $this->respond(
            new CompanyResource($company),
            'Company retrieved successfully.'
        );
    }

    public function update(UpdateCompanyRequest $request, string $code): CompanyResource
    {
        $company = $this->service->update($code, $request->validated());

        return $this->respond(
            new CompanyResource($company),
            'Company updated successfully.'
        );
    }

    public function destroy(string $code)
    {
        $deleted = $this->service->delete($code);
        if (!$deleted) {
            return $this->respondError('Company not found.', 404);
        }

        return $this->respondDeleted('Company deleted successfully.');
    }

    public function restore(string $code): CompanyResource
    {
        $company = $this->service->restore($code);
        if (!$company) {
            return $this->respondError('Company not found.', 404);
        }

        return $this->respond(
            new CompanyResource($company),
            'Company restored successfully.'
        );
    }

    public function forceDelete(string $code)
    {
        $deleted = $this->service->forceDelete($code);
        if (!$deleted) {
            return $this->respondError('Company not found.', 404);
        }

        return $this->respondDeleted('Company permanently deleted.');
    }
}
