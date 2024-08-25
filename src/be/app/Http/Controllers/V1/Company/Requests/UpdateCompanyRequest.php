<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Requests;

use App\Enums\DefaultStatus;
use App\Http\Controllers\Requests\ApiFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

/**
 * @property mixed $userId
 * @property mixed $name
 * @property mixed $status
 */
class UpdateCompanyRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $data = [];
        $method = $this->method();
        if ($method === 'PUT') {
            $data = [
                'userId' => 'required|integer|exists:users,id',
                'name' => 'required|min:3|max:50|regex:/^[a-zA-Z0-9\s]+$/',
                'status' => ['sometimes|required', Rule::in(
                    Arr::map(
                        DefaultStatus::cases(),
                        static fn($enum) => $enum->value
                    )
                )]
            ];
        } else if ($method === 'PATCH') {
            $data = [
                'userId' => 'sometimes|integer|exists:users,id',
                'name' => 'sometimes|min:3|max:50|regex:/^[a-zA-Z0-9\s]+$/',
                'status' => ['sometimes', Rule::in(
                    Arr::map(
                        DefaultStatus::cases(),
                        static fn($enum) => $enum->value
                    )
                )]
            ];
        }
        return $data;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->userId,
            'name' => $this->name,
            'status' => $this->status,
        ]);
    }
}
