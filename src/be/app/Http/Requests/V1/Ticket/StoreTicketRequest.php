<?php

namespace App\Http\Requests\V1\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_code' => ['required', 'exists:companies,code'],
            'user_id'      => ['sometimes', 'nullable', 'exists:users,id'],
            'ticket_number'=> ['required', 'string', 'max:100', 'unique:tickets'],
            'subject'      => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'priority'     => ['sometimes', 'string', 'in:low,medium,high,urgent'],
            'status'       => ['sometimes', 'string', 'in:open,in_progress,resolved,closed'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_code.required' => 'The company is required.',
            'company_code.exists'   => 'The selected company does not exist.',
            'ticket_number.required'=> 'The ticket number is required.',
            'ticket_number.unique'  => 'The ticket number is already taken.',
            'subject.required'      => 'The ticket subject is required.',
            'description.required'  => 'The ticket description is required.',
        ];
    }
}
