<?php

namespace App\Http\Controllers\V1\Project;

use App\Http\Controllers\Controller;
use App\Http\Controllers\V1\Project\Resources\ProjectResource;
use App\Models\V1\Project;

class ProjectWithTasksController extends Controller
{
    public function index($id)
    {
        return new ProjectResource(
            Project::with('tasks')->findOrFail($id)
        );
    }
}
