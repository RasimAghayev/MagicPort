<?php

namespace App\Http\Resources\V1\Contract;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractCollection extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => ContractResource::collection($this->resource),
            'meta' => [
                'current_page' => $this->currentPage(),
                'per_page'     => $this->perPage(),
                'total'        => $this->total(),
                'last_page'    => $this->lastPage(),
            ],
        ];
    }
}
