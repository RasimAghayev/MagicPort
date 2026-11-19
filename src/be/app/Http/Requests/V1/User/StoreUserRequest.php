<?php

namespace App\Http\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'status'   => ['sometimes', 'string', 'in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'      => 'The email address is required.',
            'email.unique'        => 'The email address is already registered.',
            'password.required'   => 'The password is required.',
            'password.confirmed'  => 'The password confirmation does not match.',
        ];
    }
}
