<?php

namespace Database\Seeders;

use App\Models\V1\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory()->count(1000)->create();
    }
}
