<?php

namespace Database\Seeders;

use App\Models\V1\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->count(1000)->create();
    }
}
