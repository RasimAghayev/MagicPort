<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company;



use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\Company\Resources\CompanyCollection;
use App\Http\Controllers\V1\Company\Service\CompanyServiceInterface;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * @param CompanyServiceInterface $companyRepository
     */
    public function __construct(
        protected CompanyServiceInterface $companyRepository
    ){}

    /**
     * Display a listing of the resource.
     *
     * @return CompanyCollection
     */
    public function index(Request $request): CompanyCollection
    {
        $companyService = app(CompanyServiceInterface::class);
        $includeTasks = (bool) $request->query('tasks');
        $perPage = (int) $request->query('perPage', 10);

        return $companyService->getCompanies($request,
            $includeTasks,
            $perPage);
    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param \App\Http\Requests\API\V1\StoreCustomerRequest $request
//     * @return Response
//     */
//    public function store(StoreCustomerRequest $request)
//    {
//        return new CustomerResource($request->createData());
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param \App\Models\API\V1\Customer $customer
//     * @return Response
//     */
//    public function show($id)
//    {
//        $customer = Customer::findOrFail($id);
//        if ($customer) {
//            $includeOrder = request()->query('includeCustomerOrders');
//            if ($includeOrder) {
//                $customer = $customer->loadMissing('customerorders');
//            }
//            return response()->json(data: [
//                'status' => true,
//                'message' => "Customer showed",
//                'data' => new CustomerResource($customer)
//            ]);
//        } else {
//            return response()->json([
//                'message' => "Customer ID not found",
//                'status' => false
//            ]);
//        }
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param \App\Http\Requests\API\V1\UpdateCustomerRequest $request
//     * @param \App\Models\API\V1\Customer $customer
//     * @return Response
//     */
//    public function update(UpdateCustomerRequest $request, Customer $customer)
//    {
//        $customer->update($request->all());
//        return response()->json([
//            'message' => "Customer Saved",
//            'status' => true
//        ]);
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param \App\Models\V1\Customer $customer
//     * @return Response
//     */
//    public function destroy(Customer $customer)
//    {
//        return response()->json([
//            'id' => $customer->id,
//            'status' => $customer->delete(),
//            'message' => 'Success'
//        ]);
//    }

}
