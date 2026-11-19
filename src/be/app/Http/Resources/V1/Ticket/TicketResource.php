<?php

namespace App\Http\Resources\V1\Ticket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'code'         => $this->code,
            'ticket_number'=> $this->ticket_number,
            'company_code' => $this->company_code,
            'user_id'      => $this->user_id,
            'subject'      => $this->subject,
            'description'  => $this->description,
            'priority'     => $this->priority,
            'status'       => $this->status,
            'resolved_at'  => $this->resolved_at?->toISOString(),
            'closed_at'    => $this->closed_at?->toISOString(),
            'created_at'   => $this->created_at?->toISOString(),
            'updated_at'   => $this->updated_at?->toISOString(),
            'deleted_at'   => $this->deleted_at?->toISOString(),
        ];
    }
}
