<?php

namespace App\Http\Controllers\V1\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Project\StoreProjectRequest;
use App\Http\Requests\V1\Project\UpdateProjectRequest;
use App\Http\Resources\V1\Project\ProjectCollection;
use App\Http\Resources\V1\Project\ProjectResource;
use App\Services\V1\Project\ProjectServiceInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectServiceInterface $service
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'company_id', 'user_id', 'search']);
        $perPage = (int) $request->query('perPage', 15);

        return new ProjectCollection($this->service->all($filters, $perPage));
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->service->create($request->validated());

        return $this->respondCreated(
            new ProjectResource($project),
            'Project created successfully.'
        );
    }

    public function show(string $code)
    {
        $project = $this->service->findByCode($code);
        if (!$project) {
            return $this->respondError('Project not found.', 404);
        }

        return $this->respond(
            new ProjectResource($project),
            'Project retrieved successfully.'
        );
    }

    public function update(UpdateProjectRequest $request, string $code)
    {
        $project = $this->service->update($code, $request->validated());

        return $this->respond(
            new ProjectResource($project),
            'Project updated successfully.'
        );
    }

    public function destroy(string $code)
    {
        $deleted = $this->service->delete($code);
        if (!$deleted) {
            return $this->respondError('Project not found.', 404);
        }

        return $this->respondDeleted('Project deleted successfully.');
    }

    public function restore(string $code)
    {
        $project = $this->service->restore($code);
        if (!$project) {
            return $this->respondError('Project not found.', 404);
        }

        return $this->respond(
            new ProjectResource($project),
            'Project restored successfully.'
        );
    }

    public function forceDelete(string $code)
    {
        $deleted = $this->service->forceDelete($code);
        if (!$deleted) {
            return $this->respondError('Project not found.', 404);
        }

        return $this->respondDeleted('Project permanently deleted.');
    }
}
