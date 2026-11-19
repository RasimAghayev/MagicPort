<?php

namespace App\Http\Controllers\V1\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Task\StoreTaskRequest;
use App\Http\Requests\V1\Task\UpdateTaskRequest;
use App\Http\Resources\V1\Task\TaskCollection;
use App\Http\Resources\V1\Task\TaskResource;
use App\Services\V1\Task\TaskServiceInterface;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        protected TaskServiceInterface $service
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'project_id', 'user_id', 'search']);
        $perPage = (int) $request->query('perPage', 15);

        return new TaskCollection($this->service->all($filters, $perPage));
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->service->create($request->validated());

        return $this->respondCreated(
            new TaskResource($task),
            'Task created successfully.'
        );
    }

    public function show(string $code)
    {
        $task = $this->service->findByCode($code);
        if (!$task) {
            return $this->respondError('Task not found.', 404);
        }

        return $this->respond(
            new TaskResource($task),
            'Task retrieved successfully.'
        );
    }

    public function update(UpdateTaskRequest $request, string $code)
    {
        $task = $this->service->update($code, $request->validated());

        return $this->respond(
            new TaskResource($task),
            'Task updated successfully.'
        );
    }

    public function destroy(string $code)
    {
        $deleted = $this->service->delete($code);
        if (!$deleted) {
            return $this->respondError('Task not found.', 404);
        }

        return $this->respondDeleted('Task deleted successfully.');
    }

    public function restore(string $code)
    {
        $task = $this->service->restore($code);
        if (!$task) {
            return $this->respondError('Task not found.', 404);
        }

        return $this->respond(
            new TaskResource($task),
            'Task restored successfully.'
        );
    }

    public function forceDelete(string $code)
    {
        $deleted = $this->service->forceDelete($code);
        if (!$deleted) {
            return $this->respondError('Task not found.', 404);
        }

        return $this->respondDeleted('Task permanently deleted.');
    }
}
