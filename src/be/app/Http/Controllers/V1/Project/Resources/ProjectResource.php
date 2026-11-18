<?php

namespace App\Http\Controllers\V1\Project\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'companyId' => $this->company_id,
            'userId' => $this->user_id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'createdAt' => $this->created_at->format('d.m.Y H:i:s'),
            'updatedAt' => $this->updated_at->format('d.m.Y H:i:s'),
            $this->mergeWhen($this->relationLoaded('tasks'), [
                'tasks' => ProjectTaskResource::collection($this->tasks),
            ]),
        ];
    }
}



