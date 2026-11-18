<?php

namespace App\Http\Controllers\V1\Project;

use App\Classes\ApiResponseClass;
use App\Filters\V1\ProjectFilters;
use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\Project\Requests\{StoreProjectRequest, UpdateProjectRequest};
use App\Http\Controllers\V1\Project\Resources\{ProjectCollection, ProjectResource};
use App\Http\Resources\Company\UserResource;
use App\Models\User;
use App\Models\V1\{Project};
use App\Models\V1\Company;
use Exception;
use Illuminate\Http\{JsonResponse, Request, Response};
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
//    protected $projectRepository;
//
//    public function __construct(ProjectRepositoryInterface $projectRepository)
//    {
//        $this->projectRepository = $projectRepository;
//    }
    /**
     * @param StoreProjectRequest $request
     * @return ProjectResource
     */
    public function store(StoreProjectRequest $request): ProjectResource
    {
        $this->validateModelsExistence($this->getValidateData($request));
        return new ProjectResource(Project::create($request->all()));
    }

    /**
     * @param StoreProjectRequest $request
     * @return ProjectResource
     */
    private function getValidateData($request, $id = null): array
    {
        $validateData = [
            [
                'model' => User::class,
                'request' => ['id' => $request->userId],
                'message' => 'User'
            ],
            [
                'model' => Company::class,
                'request' => ['id' => $request->companyId],
                'message' => 'Company'
            ],
            [
                'model' => Company::class,
                'request' => ['id' => $request->companyId, 'user_id' => $request->userId],
                'message' => 'Company'
            ]
        ];
        if (!is_null($id)) {
            $validateProjectData = [
                [
                    'model' => Project::class,
                    'request' => ['id' => $id,],
                    'message' => 'Project'
                ],
                [
                    'model' => Project::class,
                    'request' => ['id' => $id, 'company_id' => $request->companyId],
                    'message' => 'Project'
                ],
                [
                    'model' => Project::class,
                    'request' => ['id' => $id, 'user_id' => $request->userId],
                    'message' => 'Project'
                ],
                [
                    'model' => Project::class,
                    'request' => ['company_id' => $request->companyId, 'user_id' => $request->userId],
                    'message' => 'Project'
                ],
                [
                    'model' => Project::class,
                    'request' => ['id' => $id, 'company_id' => $request->companyId, 'user_id' => $request->userId],
                    'message' => 'Project'
                ]
            ];
        }
        return array_merge($validateData, $validateProjectData);
    }

    /**
     * @param Request $request
     * @return ProjectCollection
     */
    public function index(Request $request): ProjectCollection
    {
        $filter = new ProjectFilters();
        $queryItems = $filter->transform($request);
        $projects = Project::when($request->has('tasks'), function ($query) {
            $query->with('tasks');
        })
            ->where($queryItems);
        $perPage = $request->query('perPage', 10);
        $maxPerPage = 100;
        $perPage = min($perPage, $maxPerPage);
        $paginatedProjects = $projects->orderBy('id', 'desc')
            ->paginate($perPage)
            ->appends($request->query());
        return new ProjectCollection($paginatedProjects);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return Response
     */
    public function update(UpdateProjectRequest $request,
                           Project              $project)
    {
        /**
         *
         * if ($request->method() == 'PATCH') {
         * $data = $request->all();
         * $fields = [
         * 'companyId'=>'company_id',
         * 'userId'=>'user_id',
         * 'name'=>'name',
         * 'description'=>'description',
         * 'status'=>'status',
         * 'createdAt'=>'created_at',
         * 'updatedAt'=>'updated_at'
         * ];
         * foreach ($fields as $field=>$value) {
         * if (!array_key_exists($field, $data)) {
         * $data[$value] = $project->$value;
         * $data[$field] = $project->$value;
         * }
         * }
         * }
         * dd($data);
         */
        $this->validateModelsExistence($this->getValidateData($request, $project->id));
        DB::beginTransaction();
        try {
//            $user = $this->userRepositoryInterface->store($details);
            $project->update($request->all());
            DB::commit();

            return ApiResponseClass::sendResponse(
                new ProjectResource($project),
                'Project updated successfully.',
                201
            );
        } catch (Exception $ex) {
            return ApiResponseClass::rollback($ex,
                'An error occurred while updating the project.',
                $request);
        }
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function show(Project $project): JsonResponse
    {
        return ApiResponseClass::sendResponse(
            new ProjectResource(
                resource: Project::findOrFail($project->id)
            ),
            'Project retrieved successfully.',
            200
        );
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return ApiResponseClass::sendResponse(
            'Project Delete Successful.',
            '',
            204
        );
    }
}
