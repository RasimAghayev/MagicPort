<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\TaskRepositoryInterface;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class TaskController extends Controller
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/tasks",
     *     operationId="indexTasks",
     *     tags={"Tasks"},
     *     summary="List tasks",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="search", in="query", schema={"type":"string"}),
     *     @OA\Parameter(name="perPage", in="query", schema={"type":"integer"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Task::class);

        $tasks = $this->taskRepository->index(
            $request->query('search'),
            (int) $request->query('perPage', 15)
        );

        return TaskResource::collection($tasks)->additional([
            'message' => 'Tasks retrieved successfully.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/tasks",
     *     operationId="storeTask",
     *     tags={"Tasks"},
     *     summary="Create task",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreTaskRequest")),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);

        $task = $this->taskRepository->store($request->validated());

        return (new TaskResource($task))->additional([
            'message' => 'Task created successfully.',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/tasks/{code}",
     *     operationId="showTask",
     *     tags={"Tasks"},
     *     summary="Get task",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function show(string $code)
    {
        $task = $this->taskRepository->getByCode($code);
        $this->authorize('view', $task);

        return (new TaskResource($task))->additional([
            'message' => 'Task retrieved successfully.',
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/tasks/{code}",
     *     operationId="updateTask",
     *     tags={"Tasks"},
     *     summary="Update task",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateTaskRequest")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function update(UpdateTaskRequest $request, string $code)
    {
        $task = $this->taskRepository->getByCode($code);
        $this->authorize('update', $task);

        $task = $this->taskRepository->update($request->validated(), $code);

        return (new TaskResource($task))->additional([
            'message' => 'Task updated successfully.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/tasks/{code}",
     *     operationId="deleteTask",
     *     tags={"Tasks"},
     *     summary="Delete task",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function destroy(string $code)
    {
        $task = $this->taskRepository->getByCode($code);
        $this->authorize('delete', $task);

        $this->taskRepository->delete($code);

        return response()->noContent();
    }

    /**
     * @OA\Post(
     *     path="/api/v1/tasks/{code}/restore",
     *     operationId="restoreTask",
     *     tags={"Tasks"},
     *     summary="Restore task",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function restore(string $code)
    {
        $task = $this->taskRepository->getByCode($code);
        $this->authorize('restore', $task);

        $this->taskRepository->restore($code);

        return response()->json([
            'success' => true,
            'message' => 'Task restored successfully.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/tasks/{code}/force-delete",
     *     operationId="forceDeleteTask",
     *     tags={"Tasks"},
     *     summary="Force delete task",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function forceDelete(string $code)
    {
        $task = $this->taskRepository->getByCode($code);
        $this->authorize('force-delete', $task);

        $this->taskRepository->forceDelete($code);

        return response()->noContent();
    }
}
