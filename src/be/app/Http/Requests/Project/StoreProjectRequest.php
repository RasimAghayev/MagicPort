<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

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
            'code' => 'required|string|max:20|unique:projects,code',
            'name' => 'required|string|min:2|max:100',
            'description' => 'nullable|string',
            'company_code' => 'required|string|exists:companies,code',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Project code is required.',
            'code.unique' => 'This project code is already taken.',
            'name.required' => 'Project name is required.',
            'company_code.required' => 'Company code is required.',
            'company_code.exists' => 'The selected company does not exist.',
        ];
    }
}
