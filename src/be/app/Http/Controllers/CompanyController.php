<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\CompanyRepositoryInterface;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyRepositoryInterface $companyRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/companies",
     *     operationId="indexCompanies",
     *     tags={"Companies"},
     *     summary="List companies",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="search", in="query", schema={"type":"string"}),
     *     @OA\Parameter(name="perPage", in="query", schema={"type":"integer"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Company::class);

        $companies = $this->companyRepository->index(
            $request->query('search'),
            (int) $request->query('perPage', 15)
        );

        return CompanyResource::collection($companies)->additional([
            'message' => 'Companies retrieved successfully.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/companies",
     *     operationId="storeCompany",
     *     tags={"Companies"},
     *     summary="Create company",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreCompanyRequest")),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function store(StoreCompanyRequest $request)
    {
        $this->authorize('create', Company::class);

        $company = $this->companyRepository->store($request->validated());

        return (new CompanyResource($company))->additional([
            'message' => 'Company created successfully.',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/companies/{code}",
     *     operationId="showCompany",
     *     tags={"Companies"},
     *     summary="Get company",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function show(string $code)
    {
        $company = $this->companyRepository->getByCode($code);
        $this->authorize('view', $company);

        return (new CompanyResource($company))->additional([
            'message' => 'Company retrieved successfully.',
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/companies/{code}",
     *     operationId="updateCompany",
     *     tags={"Companies"},
     *     summary="Update company",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateCompanyRequest")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function update(UpdateCompanyRequest $request, string $code)
    {
        $company = $this->companyRepository->getByCode($code);
        $this->authorize('update', $company);

        $company = $this->companyRepository->update($request->validated(), $code);

        return (new CompanyResource($company))->additional([
            'message' => 'Company updated successfully.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/companies/{code}",
     *     operationId="deleteCompany",
     *     tags={"Companies"},
     *     summary="Delete company",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function destroy(string $code)
    {
        $company = $this->companyRepository->getByCode($code);
        $this->authorize('delete', $company);

        $this->companyRepository->delete($code);

        return response()->noContent();
    }

    /**
     * @OA\Post(
     *     path="/api/v1/companies/{code}/restore",
     *     operationId="restoreCompany",
     *     tags={"Companies"},
     *     summary="Restore company",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function restore(string $code)
    {
        $company = $this->companyRepository->getByCode($code);
        $this->authorize('restore', $company);

        $this->companyRepository->restore($code);

        return response()->json([
            'success' => true,
            'message' => 'Company restored successfully.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/companies/{code}/force-delete",
     *     operationId="forceDeleteCompany",
     *     tags={"Companies"},
     *     summary="Force delete company",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function forceDelete(string $code)
    {
        $company = $this->companyRepository->getByCode($code);
        $this->authorize('force-delete', $company);

        $this->companyRepository->forceDelete($code);

        return response()->noContent();
    }
}
