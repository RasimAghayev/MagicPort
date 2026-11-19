<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\ProjectRepositoryInterface;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectRepositoryInterface $projectRepository
    ) {}

    /**
     * @OA\Get(
     *     path="/api/v1/projects",
     *     operationId="indexProjects",
     *     tags={"Projects"},
     *     summary="List projects",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="search", in="query", schema={"type":"string"}),
     *     @OA\Parameter(name="perPage", in="query", schema={"type":"integer"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Project::class);

        $projects = $this->projectRepository->index(
            $request->query('search'),
            (int) $request->query('perPage', 15)
        );

        return ProjectResource::collection($projects)->additional([
            'message' => 'Projects retrieved successfully.',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/projects",
     *     operationId="storeProject",
     *     tags={"Projects"},
     *     summary="Create project",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreProjectRequest")),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);

        $project = $this->projectRepository->store($request->validated());

        return (new ProjectResource($project))->additional([
            'message' => 'Project created successfully.',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/projects/{code}",
     *     operationId="showProject",
     *     tags={"Projects"},
     *     summary="Get project",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function show(string $code)
    {
        $project = $this->projectRepository->getByCode($code);
        $this->authorize('view', $project);

        return (new ProjectResource($project))->additional([
            'message' => 'Project retrieved successfully.',
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/projects/{code}",
     *     operationId="updateProject",
     *     tags={"Projects"},
     *     summary="Update project",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateProjectRequest")),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function update(UpdateProjectRequest $request, string $code)
    {
        $project = $this->projectRepository->getByCode($code);
        $this->authorize('update', $project);

        $project = $this->projectRepository->update($request->validated(), $code);

        return (new ProjectResource($project))->additional([
            'message' => 'Project updated successfully.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/projects/{code}",
     *     operationId="deleteProject",
     *     tags={"Projects"},
     *     summary="Delete project",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function destroy(string $code)
    {
        $project = $this->projectRepository->getByCode($code);
        $this->authorize('delete', $project);

        $this->projectRepository->delete($code);

        return response()->noContent();
    }

    /**
     * @OA\Post(
     *     path="/api/v1/projects/{code}/restore",
     *     operationId="restoreProject",
     *     tags={"Projects"},
     *     summary="Restore project",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function restore(string $code)
    {
        $project = $this->projectRepository->getByCode($code);
        $this->authorize('restore', $project);

        $this->projectRepository->restore($code);

        return response()->json([
            'success' => true,
            'message' => 'Project restored successfully.',
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/projects/{code}/force-delete",
     *     operationId="forceDeleteProject",
     *     tags={"Projects"},
     *     summary="Force delete project",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="code", in="path", required=true, schema={"type":"string"}),
     *     @OA\Response(response=204, description="No Content")
     * )
     */
    public function forceDelete(string $code)
    {
        $project = $this->projectRepository->getByCode($code);
        $this->authorize('force-delete', $project);

        $this->projectRepository->forceDelete($code);

        return response()->noContent();
    }
}
