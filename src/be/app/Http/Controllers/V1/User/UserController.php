<?php

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\StoreUserRequest;
use App\Http\Requests\V1\User\UpdateUserRequest;
use App\Http\Resources\V1\User\UserCollection;
use App\Http\Resources\V1\User\UserResource;
use App\Services\V1\User\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserServiceInterface $service
    ) {}

    public function index(Request $request): UserCollection
    {
        $filters = $request->only(['status', 'search']);
        $perPage = (int) $request->query('perPage', 15);

        return $this->respond(
            new UserCollection($this->service->all($filters, $perPage)),
            'Users retrieved successfully.'
        );
    }

    public function store(StoreUserRequest $request): UserResource
    {
        $user = $this->service->create($request->validated());

        return $this->respondCreated(
            new UserResource($user),
            'User created successfully.'
        );
    }

    public function show(int $id): UserResource
    {
        $user = $this->service->findById($id);
        if (!$user) {
            return $this->respondError('User not found.', 404);
        }

        return $this->respond(
            new UserResource($user),
            'User retrieved successfully.'
        );
    }

    public function update(UpdateUserRequest $request, int $id): UserResource
    {
        $user = $this->service->update($id, $request->validated());

        return $this->respond(
            new UserResource($user),
            'User updated successfully.'
        );
    }

    public function destroy(int $id)
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) {
            return $this->respondError('User not found.', 404);
        }

        return $this->respondDeleted('User deleted successfully.');
    }

    public function restore(int $id): UserResource
    {
        $user = $this->service->restore($id);
        if (!$user) {
            return $this->respondError('User not found.', 404);
        }

        return $this->respond(
            new UserResource($user),
            'User restored successfully.'
        );
    }

    public function forceDelete(int $id)
    {
        $deleted = $this->service->forceDelete($id);
        if (!$deleted) {
            return $this->respondError('User not found.', 404);
        }

        return $this->respondDeleted('User permanently deleted.');
    }
}
