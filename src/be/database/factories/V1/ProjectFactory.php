<?php

namespace Database\Factories\V1;

use App\Enums\DefaultStatus;
use App\Models\User;
use App\Models\V1\Company;
use App\Models\V1\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userIds = User::all()->pluck('id')->toArray();
        $companyIds = Company::all()->pluck('id')->toArray();
        return [
            'company_id' => $this->faker->randomElement($companyIds),
            'user_id' => $this->faker->randomElement($userIds),
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'status' => $this->faker->randomElement(DefaultStatus::cases())->value,
        ];
    }
}
