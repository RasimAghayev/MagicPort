<?php

namespace Database\Factories\V1;

use App\Models\V1\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'code'         => strtoupper($this->faker->bothify('TKT#####')),
            'ticket_number'=> 'TKT-' . strtoupper($this->faker->bothify('#######')),
            'company_code' => null,
            'user_id'      => null,
            'subject'      => $this->faker->sentence(6),
            'description'  => $this->faker->paragraph(),
            'priority'     => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'status'       => $this->faker->randomElement(['open', 'in_progress', 'resolved', 'closed']),
            'resolved_at'  => null,
            'closed_at'    => null,
        ];
    }
}
