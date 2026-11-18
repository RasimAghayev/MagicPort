<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\V1\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::factory()->count(1000)->create();
    }
}
