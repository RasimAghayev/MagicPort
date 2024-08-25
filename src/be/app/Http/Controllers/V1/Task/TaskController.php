<?php

namespace App\Http\Controllers\V1\Task;

use App\Filters\V1\ProjectFilters;
use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\Customer;
use App\Http\Controllers\V1\CustomerResource;
use App\Http\Controllers\V1\ProjectCollection;
use App\Http\Controllers\V1\StoreCustomerRequest;
use App\Http\Controllers\V1\UpdateCustomerRequest;
use App\Models\V1\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
//    protected $projectRepository;
//
//    public function __construct(ProjectRepositoryInterface $projectRepository)
//    {
//        $this->projectRepository = $projectRepository;
//    }

    /**
     * Display a listing of the resource.
     *
     * @return ProjectCollection
     */
    public function index(Request $request)
    {
        $filter = new ProjectFilters();
        $queryItems = $filter->transform($request);
        $customers = Project::select('id', 'name', 'type', 'created_at', 'updated_at')->where($queryItems);
        $includeOrder = $request->query('tasks');
        if ($includeOrder) {
            $customers = $customers->with('projecttasks');
        }
        $perPage = $request->query('perPage', 10);
        $maxPerPage = 100;

        $perPage = min($perPage, $maxPerPage);
        return new ProjectCollection(
            $customers->orderBy('id', 'desc')
                ->paginate($perPage)
                ->appends(
                    $request->query()
                )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\API\V1\StoreCustomerRequest $request
     * @return Response
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource($request->createData());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\API\V1\Customer $customer
     * @return Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        if ($customer) {
            $includeOrder = request()->query('includeCustomerOrders');
            if ($includeOrder) {
                $customer = $customer->loadMissing('customerorders');
            }
            return response()->json(data: [
                'status' => true,
                'message' => "Customer showed",
                'data' => new CustomerResource($customer)
            ]);
        } else {
            return response()->json([
                'message' => "Customer ID not found",
                'status' => false
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\API\V1\UpdateCustomerRequest $request
     * @param \App\Models\API\V1\Customer $customer
     * @return Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        return response()->json([
            'message' => "Customer Saved",
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\V1\Customer $customer
     * @return Response
     */
    public function destroy(Customer $customer)
    {
        return response()->json([
            'id' => $customer->id,
            'status' => $customer->delete(),
            'message' => 'Success'
        ]);
    }

}
