<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'company_code' => $this->company_code,
            'project_code' => $this->project_code,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'due_date' => $this->due_date?->format('Y-m-d'),
            'priority' => $this->priority,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'deleted_at' => $this->deleted_at?->toISOString(),
            'company' => $this->whenLoaded('company'),
            'project' => $this->whenLoaded('project'),
            'user' => $this->whenLoaded('user'),
        ];
    }
}
