<?php

namespace App\Http\Requests\V1\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'   => ['required', 'exists:users,id'],
            'name'      => ['required', 'string', 'max:255'],
            'code'      => ['required', 'string', 'max:50', 'unique:companies'],
            'status'    => ['sometimes', 'string', 'in:active,inactive,suspended'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'The company name is required.',
            'code.required'  => 'The company code is required.',
            'code.unique'    => 'The company code is already taken.',
            'user_id.exists' => 'The selected user does not exist.',
        ];
    }
}
