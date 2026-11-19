<?php

namespace App\Http\Requests\V1\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ticket_number'=> ['sometimes', 'required', 'string', 'max:100', 'unique:tickets,ticket_number,' . $this->route('code') . ',code'],
            'subject'      => ['sometimes', 'required', 'string', 'max:255'],
            'description'  => ['sometimes', 'required', 'string'],
            'priority'     => ['sometimes', 'string', 'in:low,medium,high,urgent'],
            'status'       => ['sometimes', 'string', 'in:open,in_progress,resolved,closed'],
            'user_id'      => ['sometimes', 'nullable', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'ticket_number.unique' => 'The ticket number is already taken.',
        ];
    }
}
