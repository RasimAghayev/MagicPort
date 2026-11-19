<?php

namespace App\Http\Requests\V1\Task;

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
            'project_code' => ['required', 'exists:projects,code'],
            'user_id'    => ['sometimes', 'nullable', 'exists:users,id'],
            'title'      => ['required', 'string', 'max:255'],
            'code'       => ['required', 'string', 'max:50', 'unique:tasks'],
            'status'     => ['sometimes', 'string', 'in:todo,in_progress,review,done'],
            'due_date'   => ['sometimes', 'nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => 'The task title is required.',
            'code.required'    => 'The task code is required.',
            'code.unique'      => 'The task code is already taken.',
            'project_code.exists'=> 'The selected project does not exist.',
        ];
    }
}
