<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->bothify('TSK#####')),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(),
            'company_code' => Company::factory(),
            'project_code' => Project::factory(),
            'user_id' => User::factory(),
            'status' => $this->faker->randomElement(['todo', 'in_progress', 'review', 'done', 'blocked']),
            'due_date' => $this->faker->date('Y-m-d', '+30 days'),
            'priority' => $this->faker->numberBetween(1, 5),
            'is_active' => true,
        ];
    }
}
