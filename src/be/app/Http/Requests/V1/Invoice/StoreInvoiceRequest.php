<?php

namespace App\Http\Requests\V1\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_code'  => ['required', 'exists:companies,code'],
            'invoice_number'=> ['required', 'string', 'max:100', 'unique:invoices'],
            'amount'        => ['required', 'numeric', 'min:0'],
            'tax_amount'    => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'total_amount'  => ['required', 'numeric', 'min:0'],
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
            'company_code.required'  => 'The company is required.',
            'company_code.exists'    => 'The selected company does not exist.',
            'invoice_number.required'=> 'The invoice number is required.',
            'invoice_number.unique'  => 'The invoice number is already taken.',
            'amount.required'        => 'The amount is required.',
            'total_amount.required'  => 'The total amount is required.',
        ];
    }
}
