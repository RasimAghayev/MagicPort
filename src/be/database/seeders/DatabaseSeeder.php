<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Company::factory()->count(3)->create()->each(function (Company $company) {
            Project::factory()->count(3)->create(['company_code' => $company->code])->each(function (Project $project) use ($company) {
                Task::factory()->count(5)->create([
                    'company_code' => $company->code,
                    'project_code' => $project->code,
                ])->each(function (Task $task) {
                    User::factory()->create();
                });
            });
        });
    }
}
