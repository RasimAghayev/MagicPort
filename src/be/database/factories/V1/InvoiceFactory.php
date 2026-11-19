<?php

namespace Database\Factories\V1;

use App\Models\V1\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'code'          => strtoupper($this->faker->bothify('INV#####')),
            'invoice_number'=> 'INV-' . strtoupper($this->faker->bothify('#######')),
            'company_code'  => null,
            'amount'        => $this->faker->randomFloat(2, 10, 10000),
            'tax_amount'    => $this->faker->randomFloat(2, 0, 500),
            'total_amount'  => $this->faker->randomFloat(2, 10, 10500),
            'status'        => $this->faker->randomElement(['draft', 'sent', 'paid', 'overdue', 'cancelled']),
            'issued_at'     => $this->faker->date('Y-m-d', '-1 year'),
            'due_date'      => $this->faker->date('Y-m-d', '+6 months'),
            'paid_at'       => null,
            'notes'         => $this->faker->sentence(),
        ];
    }
}
