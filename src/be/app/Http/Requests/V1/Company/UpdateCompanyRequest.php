<?php

namespace App\Http\Requests\V1\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => ['sometimes', 'required', 'string', 'max:255'],
            'code'  => ['sometimes', 'required', 'string', 'max:50', 'unique:companies,code,' . $this->route('code')],
            'status'=> ['sometimes', 'string', 'in:active,inactive,suspended'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'The company code is already taken.',
        ];
    }
}
