<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $code = $this->route('code');

        return [
            'code' => 'sometimes|string|max:20|unique:tasks,code,' . $code . ',code',
            'name' => 'sometimes|string|min:2|max:100',
            'description' => 'sometimes|nullable|string',
            'company_code' => 'sometimes|required|string|exists:companies,code',
            'project_code' => 'sometimes|required|string|exists:projects,code',
            'user_id' => 'sometimes|nullable|integer|exists:users,id',
            'status' => 'sometimes|string|in:pending,in_progress,completed,cancelled',
            'due_date' => 'sometimes|nullable|date',
            'priority' => 'sometimes|integer|min:1|max:5',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'This task code is already taken.',
            'company_code.exists' => 'The selected company does not exist.',
            'project_code.exists' => 'The selected project does not exist.',
        ];
    }
}
