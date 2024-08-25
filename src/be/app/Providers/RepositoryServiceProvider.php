<?php

namespace App\Providers;


use App\Http\Controllers\V1\Company\Repository\{CompanyRepositoryInterface,CompanyRepository};
use App\Http\Controllers\V1\Company\Service\{CompanyServiceInterface, CompanyService};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CompanyServiceInterface::class, CompanyService::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
