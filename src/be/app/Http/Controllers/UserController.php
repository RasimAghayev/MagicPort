<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     operationId="indexUsers",
     *     tags={"Users"},
     *     summary="List users",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="search", in="query", schema={"type":"string"}),
     *     @OA\Parameter(name="perPage", in="query", schema={"type":"integer"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', User::class);

        $users = $this->userRepository->index(
            $request->query('search'),
            (int) $request->query('perPage', 15)
        );

        return UserResource::collection($users)->additional([
            'message' => 'Users retrieved successfully.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     operationId="storeUser",
     *     tags={"Users"},
     *     summary="Create user",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        $user = $this->userRepository->store($request->validated());

        return (new UserResource($user))->additional([
            'message' => 'User created successfully.',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{id}",
     *     operationId="showUser",
     *     tags={"Users"},
     *     summary="Get user",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, schema={"type":"integer"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function show(int $id)
    {
        $user = $this->userRepository->getById($id);
        $this->authorize('view', $user);

        return (new UserResource($user))->additional([
            'message' => 'User retrieved successfully.',
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/users/{id}",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     summary="Update user",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, schema={"type":"integer"}),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->userRepository->getById($id);
        $this->authorize('update', $user);

        $user = $this->userRepository->update($request->validated(), $id);

        return (new UserResource($user))->additional([
            'message' => 'User updated successfully.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users/{id}",
     *     operationId="deleteUser",
     *     tags={"Users"},
     *     summary="Delete user",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, schema={"type":"integer"}),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function destroy(int $id)
    {
        $user = $this->userRepository->getById($id);
        $this->authorize('delete', $user);

        $this->userRepository->delete($id);

        return response()->noContent();
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/{id}/restore",
     *     operationId="restoreUser",
     *     tags={"Users"},
     *     summary="Restore user",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, schema={"type":"integer"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function restore(int $id)
    {
        $user = $this->userRepository->getById($id);
        $this->authorize('restore', $user);

        $this->userRepository->restore($id);

        return response()->json([
            'success' => true,
            'message' => 'User restored successfully.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users/{id}/force-delete",
     *     operationId="forceDeleteUser",
     *     tags={"Users"},
     *     summary="Force delete user",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, schema={"type":"integer"}),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function forceDelete(int $id)
    {
        $user = $this->userRepository->getById($id);
        $this->authorize('force-delete', $user);

        $this->userRepository->forceDelete($id);

        return response()->noContent();
    }
}
