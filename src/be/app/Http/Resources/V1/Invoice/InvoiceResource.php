<?php

namespace App\Http\Resources\V1\Invoice;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'code'          => $this->code,
            'invoice_number'=> $this->invoice_number,
            'company_code'  => $this->company_code,
            'amount'        => (float) $this->amount,
            'tax_amount'    => (float) $this->tax_amount,
            'total_amount'  => (float) $this->total_amount,
            'status'        => $this->status,
            'issued_at'     => $this->issued_at?->toISOString(),
            'due_date'      => $this->due_date?->toISOString(),
            'paid_at'       => $this->paid_at?->toISOString(),
            'notes'         => $this->notes,
            'created_at'    => $this->created_at?->toISOString(),
            'updated_at'    => $this->updated_at?->toISOString(),
            'deleted_at'    => $this->deleted_at?->toISOString(),
        ];
    }
}
