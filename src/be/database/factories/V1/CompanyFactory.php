<?php

namespace Database\Factories\V1;

use App\Enums\DefaultStatus;
use App\Models\User;
use App\Models\V1\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'status' => $this->faker->randomElement(DefaultStatus::cases())->value,
        ];
    }
}
