<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $code = $this->route('code');

        return [
            'code' => 'sometimes|string|max:20|unique:projects,code,' . $code . ',code',
            'name' => 'sometimes|string|min:2|max:100',
            'description' => 'sometimes|nullable|string',
            'company_code' => 'sometimes|required|string|exists:companies,code',
            'start_date' => 'sometimes|nullable|date',
            'end_date' => 'sometimes|nullable|date|after_or_equal:start_date',
            'budget' => 'sometimes|nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'This project code is already taken.',
            'company_code.exists' => 'The selected company does not exist.',
        ];
    }
}
