<?php

namespace App\Http\Resources\V1\Contract;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'code'           => $this->code,
            'contract_number'=> $this->contract_number,
            'company_code'   => $this->company_code,
            'title'          => $this->title,
            'description'    => $this->description,
            'start_date'     => $this->start_date?->toISOString(),
            'end_date'       => $this->end_date?->toISOString(),
            'value'          => (float) $this->value,
            'status'         => $this->status,
            'signed_at'      => $this->signed_at?->toISOString(),
            'created_at'     => $this->created_at?->toISOString(),
            'updated_at'     => $this->updated_at?->toISOString(),
            'deleted_at'     => $this->deleted_at?->toISOString(),
        ];
    }
}
