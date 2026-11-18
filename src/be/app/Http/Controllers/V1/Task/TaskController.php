<?php

namespace App\Http\Controllers\V1\Task;

use App\Classes\ApiResponseClass;
use App\Filters\V1\TaskFilters;
use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\Task\Requests\{StoreTaskRequest, UpdateTaskRequest};
use App\Http\Controllers\V1\Task\Resources\{TaskCollection, TaskResource};
use App\Models\V1\Task;
use Exception;
use Illuminate\Http\{JsonResponse, Request, Response};
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * @param StoreTaskRequest $request
     * @return TaskResource
     */
    public function store(StoreTaskRequest $request): TaskResource
    {
        $task = Task::create($request->all());
        return new TaskResource($task);
    }

    /**
     * @param Request $request
     * @return TaskCollection
     */
    public function index(Request $request): TaskCollection
    {
        $filter = new TaskFilters();
        $queryItems = $filter->transform($request);
        $tasks = Task::when($request->has('projects'), function ($query) {
            $query->with('project');
        })
            ->where($queryItems);
        $perPage = $request->query('perPage', 10);
        $maxPerPage = 100;
        $perPage = min($perPage, $maxPerPage);
        $paginatedTasks = $tasks->orderBy('id', 'desc')
            ->paginate($perPage)
            ->appends($request->query());
        return new TaskCollection($paginatedTasks);
    }

    /**
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return Response
     */
    public function update(UpdateTaskRequest $request,
                           Task              $task)
    {
        DB::beginTransaction();
        try {
            $task->update($request->all());
            DB::commit();

            return ApiResponseClass::sendResponse(
                new TaskResource($task),
                'Task updated successfully.',
                201
            );
        } catch (Exception $ex) {
            return ApiResponseClass::rollback($ex,
                'An error occurred while updating the task.',
                $request);
        }
    }

    /**
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Task $task): JsonResponse
    {
        return ApiResponseClass::sendResponse(
            new TaskResource(
                resource: Task::findOrFail($task->id)
            ),
            'Task retrieved successfully.',
            200
        );
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return ApiResponseClass::sendResponse(
            'Task Delete Successful.',
            '',
            204
        );
    }
}
