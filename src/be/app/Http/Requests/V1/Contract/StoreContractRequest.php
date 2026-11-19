<?php

namespace App\Http\Requests\V1\Contract;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_code'  => ['required', 'exists:companies,code'],
            'contract_number'=> ['required', 'string', 'max:100', 'unique:contracts'],
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['sometimes', 'nullable', 'string'],
            'start_date'    => ['sometimes', 'nullable', 'date'],
            'end_date'      => ['sometimes', 'nullable', 'date'],
            'value'         => ['required', 'numeric', 'min:0'],
            'status'        => ['sometimes', 'string', 'in:draft,active,expired,terminated,renewed'],
            'signed_at'     => ['sometimes', 'nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_code.required'   => 'The company is required.',
            'company_code.exists'     => 'The selected company does not exist.',
            'contract_number.required'=> 'The contract number is required.',
            'contract_number.unique'  => 'The contract number is already taken.',
            'title.required'          => 'The contract title is required.',
            'value.required'          => 'The contract value is required.',
        ];
    }
}
