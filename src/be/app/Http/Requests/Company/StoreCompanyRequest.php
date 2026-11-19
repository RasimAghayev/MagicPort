<?php

declare(strict_types=1);

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:20|unique:companies,code',
            'name' => 'required|string|min:2|max:100',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:companies,email',
            'established_at' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Company code is required.',
            'code.unique' => 'This company code is already taken.',
            'name.required' => 'Company name is required.',
            'email.unique' => 'This email is already registered.',
        ];
    }
}
