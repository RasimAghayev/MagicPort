<?php

namespace Database\Factories\V1;

use App\Models\User;
use App\Models\V1\Company;
use App\Models\V1\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'code'         => 'P' . strtoupper(Str::random(6)),
            'name'         => $this->faker->company . ' Project',
            'description'  => $this->faker->sentence,
            'company_code' => Company::factory(),
            'user_id'      => User::factory(),
            'status'       => $this->faker->randomElement(['active', 'inactive', 'completed']),
        ];
    }
}
