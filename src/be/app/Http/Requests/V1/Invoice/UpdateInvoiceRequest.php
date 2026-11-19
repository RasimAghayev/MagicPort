<?php

namespace App\Http\Requests\V1\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_number'=> ['sometimes', 'required', 'string', 'max:100', 'unique:invoices,invoice_number,' . $this->route('code') . ',code'],
            'amount'        => ['sometimes', 'required', 'numeric', 'min:0'],
            'tax_amount'    => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'total_amount'  => ['sometimes', 'required', 'numeric', 'min:0'],
            'status'        => ['sometimes', 'string', 'in:draft,sent,paid,overdue,cancelled'],
            'issued_at'     => ['sometimes', 'nullable', 'date'],
            'due_date'      => ['sometimes', 'nullable', 'date'],
            'paid_at'       => ['sometimes', 'nullable', 'date'],
            'notes'         => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'invoice_number.unique' => 'The invoice number is already taken.',
        ];
    }
}
