<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\DepartmentRepository;

class DepartmentRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Repositories\DepartmentRepositoryInterface', function($app)   {
            return new DepartmentRepository($this->app['App\Department']);
        });
    }
}
