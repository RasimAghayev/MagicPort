<?php

namespace Database\Seeders;

use App\Enums\DefaultStatus;
use App\Models\User;
use App\Models\V1\{Company,Project};
use Illuminate\Database\Seeder;
use Random\RandomException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws RandomException
     */
    public function run(): void
    {
//        $this->call([
//            UserSeeder::class,
//            CompanySeeder::class,
//            ProjectSeeder::class,
//            TaskSeeder::class,
//        ]);

        $users = User::factory()->count(100)->create();
        Company::factory()
            ->count(10)
            ->make()
            ->each(function ($company) use ($users) {
                $company->save();
                Project::factory()
                    ->count(15)
                    ->hasTasks(25)
                    ->create(['company_id' => $company->id]);

                $company->users()->attach(
                    $users->random(random_int(1, 10))->pluck('id')->toArray(),
                    [
                        'status' => DefaultStatus::ACTIVATED->value,
                    ]
                );
            })
        ;
    }
}
