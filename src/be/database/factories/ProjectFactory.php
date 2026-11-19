<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->bothify('PRJ#####')),
            'name' => $this->faker->catchPhrase(),
            'description' => $this->faker->sentence(),
            'company_code' => Company::factory(),
            'start_date' => $this->faker->date('Y-m-d'),
            'end_date' => $this->faker->date('Y-m-d', '+1 year'),
            'budget' => $this->faker->randomFloat(2, 1000, 100000),
            'is_active' => true,
        ];
    }
}
