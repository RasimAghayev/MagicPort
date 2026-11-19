<?php

namespace Database\Factories\V1;

use App\Models\V1\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        return [
            'code'           => strtoupper($this->faker->bothify('CTR#####')),
            'contract_number'=> 'CTR-' . strtoupper($this->faker->bothify('#######')),
            'company_code'   => null,
            'title'          => $this->faker->sentence(4),
            'description'    => $this->faker->paragraph(),
            'start_date'     => $this->faker->date('Y-m-d', '-1 year'),
            'end_date'       => $this->faker->date('Y-m-d', '+1 year'),
            'value'          => $this->faker->randomFloat(2, 1000, 50000),
            'status'         => $this->faker->randomElement(['draft', 'active', 'expired', 'terminated', 'renewed']),
            'signed_at'      => null,
        ];
    }
}
