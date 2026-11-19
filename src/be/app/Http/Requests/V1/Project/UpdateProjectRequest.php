<?php

namespace App\Http\Requests\V1\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => ['sometimes', 'required', 'string', 'max:255'],
            'code'   => ['sometimes', 'required', 'string', 'max:50', 'unique:projects,code,' . $this->route('code')],
            'status' => ['sometimes', 'string', 'in:active,inactive,completed'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'The project code is already taken.',
        ];
    }
}
