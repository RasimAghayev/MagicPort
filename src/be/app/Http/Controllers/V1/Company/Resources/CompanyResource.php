<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @method relationLoaded(string $string)
 * @property mixed $tasks
 * @property mixed $updated_at
 * @property mixed $created_at
 * @property mixed $status
 * @property mixed $name
 * @property mixed $user_id
 * @property mixed $users
 * @property mixed $projects
 */
class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray(Request $request)
    {
        return [
            'userId' => $this->user_id,
            'name' => $this->name,
            'status' => $this->status,
            'createdAt' => $this->created_at->format('d.m.Y H:i:s'),
            'updatedAt' => $this->updated_at->format('d.m.Y H:i:s'),
            $this->mergeWhen($this->relationLoaded('users'), [
                'users' => CompanyUserResource::collection($this->users),
            ]),
            $this->mergeWhen($this->relationLoaded('projects'), [
                'projects' => CompanyProjectResource::collection($this->projects),
            ]),
            $this->mergeWhen($this->relationLoaded('tasks'), [
                'tasks' => CompanyTaskResource::collection($this->tasks),
            ]),
        ];
    }
}



