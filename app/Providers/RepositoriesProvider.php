<?php

namespace App\Providers;

use App\Repositories\BaseInterface;
use App\Repositories\CompanyInterface;
use App\Repositories\EmployeeInterface;
use App\Repositories\Impl\BaseRepository;
use App\Repositories\Impl\CompanyRepository;
use App\Repositories\Impl\EmployeeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseInterface::class, BaseRepository::class);
        $this->app->bind(CompanyInterface::class, CompanyRepository::class);
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
