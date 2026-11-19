<?php

declare(strict_types=1);

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $code = $this->route('code');

        return [
            'code' => 'sometimes|string|max:20|unique:companies,code,' . $code . ',code',
            'name' => 'sometimes|string|min:2|max:100',
            'address' => 'sometimes|nullable|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'email' => 'sometimes|nullable|email|unique:companies,email,' . $code . ',code',
            'established_at' => 'sometimes|nullable|date',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'This company code is already taken.',
            'email.unique' => 'This email is already registered.',
        ];
    }
}
