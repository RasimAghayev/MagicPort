<?php

namespace App\Http\Requests\V1\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'   => ['sometimes', 'required', 'string', 'max:255'],
            'code'    => ['sometimes', 'required', 'string', 'max:50', 'unique:tasks,code,' . $this->route('code')],
            'status'  => ['sometimes', 'string', 'in:todo,in_progress,review,done'],
            'due_date'=> ['sometimes', 'nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'The task code is already taken.',
        ];
    }
}
