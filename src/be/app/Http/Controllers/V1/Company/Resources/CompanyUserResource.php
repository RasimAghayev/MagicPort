<?php

namespace App\Http\Controllers\V1\Company\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class CompanyUserResource extends JsonResource
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
            'userId' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'createdAt' => $this->created_at->format('d.m.Y H:i:s'),
            'updatedAt' => $this->updated_at->format('d.m.Y H:i:s'),
        ];
    }
}



