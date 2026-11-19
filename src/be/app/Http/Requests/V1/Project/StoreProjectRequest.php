<?php

namespace App\Http\Requests\V1\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_code' => ['required', 'exists:companies,code'],
            'user_id'    => ['required', 'exists:users,id'],
            'name'       => ['required', 'string', 'max:255'],
            'code'       => ['required', 'string', 'max:50', 'unique:projects'],
            'status'     => ['sometimes', 'string', 'in:active,inactive,completed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'The project name is required.',
            'code.required'       => 'The project code is required.',
            'code.unique'         => 'The project code is already taken.',
            'company_code.exists'   => 'The selected company does not exist.',
            'user_id.exists'      => 'The selected user does not exist.',
        ];
    }
}
