<?php

namespace Database\Factories\V1;

use App\Enums\V1\TaskStatus;
use App\Models\User;
use App\Models\V1\Company;
use App\Models\V1\Project;
use App\Models\V1\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $companyIds = Company::all()->pluck('id')->toArray();
        $userIds = User::all()->pluck('id')->toArray();
        $projectIds = Project::all()->pluck('id')->toArray();
        return [
            'company_id' => $this->faker->randomElement($companyIds),
            'user_id' => $this->faker->randomElement($userIds),
            'project_id' => $this->faker->randomElement($projectIds),
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'status' => $this->faker->randomElement(TaskStatus::cases())->value,
        ];
    }
}
