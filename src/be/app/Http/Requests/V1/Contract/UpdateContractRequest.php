<?php

namespace App\Http\Requests\V1\Contract;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contract_number'=> ['sometimes', 'required', 'string', 'max:100', 'unique:contracts,contract_number,' . $this->route('code') . ',code'],
            'title'         => ['sometimes', 'required', 'string', 'max:255'],
            'description'   => ['sometimes', 'nullable', 'string'],
            'start_date'    => ['sometimes', 'nullable', 'date'],
            'end_date'      => ['sometimes', 'nullable', 'date'],
            'value'         => ['sometimes', 'required', 'numeric', 'min:0'],
            'status'        => ['sometimes', 'string', 'in:draft,active,expired,terminated,renewed'],
            'signed_at'     => ['sometimes', 'nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'contract_number.unique' => 'The contract number is already taken.',
        ];
    }
}
