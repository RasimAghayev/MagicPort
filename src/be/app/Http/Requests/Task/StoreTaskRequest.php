<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:20|unique:tasks,code',
            'name' => 'required|string|min:2|max:100',
            'description' => 'nullable|string',
            'company_code' => 'required|string|exists:companies,code',
            'project_code' => 'required|string|exists:projects,code',
            'user_id' => 'nullable|integer|exists:users,id',
            'status' => 'sometimes|string|in:pending,in_progress,completed,cancelled',
            'due_date' => 'nullable|date',
            'priority' => 'sometimes|integer|min:1|max:5',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Task code is required.',
            'code.unique' => 'This task code is already taken.',
            'name.required' => 'Task name is required.',
            'company_code.exists' => 'The selected company does not exist.',
            'project_code.exists' => 'The selected project does not exist.',
        ];
    }
}
