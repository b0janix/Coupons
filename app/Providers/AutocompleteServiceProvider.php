<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AutocompleteService;

class AutocompleteServiceProvider extends ServiceProvider
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
 $this->app->bind('App\Services\AutocompleteServiceInterface', function($app)   {
return new AutocompleteService($this->app['App\Repositories\WorkerRepositoryInterface'],
                               $this->app['App\Repositories\CouponRepositoryInterface'],
                               $this->app['App\Repositories\DepartmentRepositoryInterface'],
                               $this->app['App\Repositories\MonthRepositoryInterface'],
                               $this->app['App\Repositories\MealRepositoryInterface']
    );
    });
    }

}
