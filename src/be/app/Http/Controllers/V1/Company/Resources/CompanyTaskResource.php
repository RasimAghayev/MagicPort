<?php

namespace App\Http\Controllers\V1\Company\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property mixed $user_id
 * @property mixed $project_id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $status
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class CompanyTaskResource extends JsonResource
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
            'userId' => $this->user_id,
            'projectId' => $this->project_id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'createdAt' => $this->created_at->format('d.m.Y H:i:s'),
            'updatedAt' => $this->updated_at->format('d.m.Y H:i:s'),
        ];
    }
}



