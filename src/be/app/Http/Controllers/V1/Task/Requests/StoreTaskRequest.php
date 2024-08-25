<?php

namespace App\Http\Controllers\V1\Task\Requests;

use App\Enums\V1\TaskStatus;
use App\Http\Controllers\Requests\ApiFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends ApiFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'companyId' => 'required|integer|exists:companies,id',
            'userId' => 'required|integer|exists:users,id',
            'projectId' => 'required|integer|exists:projects,id',
            'name' => 'required|min:3|max:150',
            'description' => 'required|min:2|max:1000',
            'status' => ['required', Rule::in(Arr::map(TaskStatus::cases(), static fn($enum) => $enum->value))],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'company_id' => $this->companyId,
            'user_id' => $this->userId,
            'project_id' => $this->projectId,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);
    }
}
