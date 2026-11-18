<?php

namespace App\Http\Controllers\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\{JsonResponse, Request, Response};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Enums\UserStatus;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $perPage = $request->query('perPage', 10);
        $maxPerPage = 100;
        $perPage = min($perPage, $maxPerPage);

        $users = User::orderBy('id', 'desc')
            ->paginate($perPage)
            ->appends($request->query());

        return ApiResponseClass::sendResponse(
            $users,
            'Users retrieved successfully.',
            200
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'status' => ['sometimes', Rule::in(UserStatus::cases())],
        ]);

        if ($validator->fails()) {
            return ApiResponseClass::sendResponse(
                $validator->errors(),
                'Validation failed.',
                422
            );
        }

        DB::beginTransaction();
        try {
            $data = $validator->validated();
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            $user = User::create($data);
            DB::commit();

            return ApiResponseClass::sendResponse(
                $user,
                'Company User Create Successful',
                201
            );
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return ApiResponseClass::sendResponse(
            $user,
            '',
            200
        );
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user): Response
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|min:2|max:50',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8',
            'status' => ['sometimes', Rule::in(UserStatus::cases())],
        ]);

        if ($validator->fails()) {
            return ApiResponseClass::sendResponse(
                $validator->errors(),
                'Validation failed.',
                422
            );
        }

        DB::beginTransaction();
        try {
            $data = $validator->validated();
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            $user->update($data);
            DB::commit();

            return ApiResponseClass::sendResponse(
                $user,
                'Company User Update Successful',
                201
            );
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        $user->delete();

        return ApiResponseClass::sendResponse(
            'Company User Delete Successful',
            '',
            204
        );
    }
}
