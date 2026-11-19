<?php

namespace Database\Factories\V1;

use App\Models\User;
use App\Models\V1\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'code'   => 'C' . strtoupper(Str::random(6)),
            'name'   => $this->faker->company,
            'user_id'=> User::factory(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'suspended']),
        ];
    }
}
