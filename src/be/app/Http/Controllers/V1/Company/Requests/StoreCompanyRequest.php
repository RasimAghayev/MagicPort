<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\Company\Requests;

use App\Enums\DefaultStatus;
use App\Http\Controllers\Requests\ApiFormRequest;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends ApiFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userId' => 'required|integer|exists:users,id',
            'name' => 'required|min:3|max:50|regex:/^[a-zA-Z0-9\s]+$/',
            'status' => ['required', Rule::in(
                Arr::map(
                    DefaultStatus::cases(),
                    static fn($enum) => $enum->value
                )
            )],
        ];
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
