<?php

namespace App\Http\Controllers\V1\Task\Resources;

use App\Http\V1\Resources\Auth\AuthResource;
use App\Traits\PaginationLinksTrait;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class TaskCollection extends ResourceCollection
{
    use PaginationLinksTrait;

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => TaskResource::collection($this->collection),
            'links' => [
                'self' => $this->getSelfLink(),
                'first' => $this->getFirstLink(),
                'last' => $this->getLastLink(),
                'prev' => $this->getPrevLink(),
                'next' => $this->getNextLink(),
            ],
        ];
    }
}
