<?php

namespace Database\Factories\V1;

use App\Models\User;
use App\Models\V1\Project;
use App\Models\V1\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'code'         => 'T' . strtoupper(Str::random(6)),
            'title'        => $this->faker->sentence(3),
            'description'  => $this->faker->sentence,
            'project_code' => Project::factory(),
            'user_id'      => User::factory(),
            'status'       => $this->faker->randomElement(['todo', 'in_progress', 'review', 'done']),
            'due_date'     => $this->faker->optional()->dateTimeBetween('now', '+30 days'),
            'priority'     => $this->faker->numberBetween(1, 5),
        ];
    }
}
