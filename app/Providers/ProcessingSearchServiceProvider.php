<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ProcessingSearchService;

class ProcessingSearchServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\ProcessingSearchServiceInterface', function($app)   {
return new ProcessingSearchService($this->app['App\Repositories\DepartmentRepositoryInterface'],
                                     $this->app['App\Repositories\CouponRepositoryInterface'],
                                     $this->app['App\Repositories\ConstructionSiteRepositoryInterface'],
                                     $this->app['App\Repositories\NewMealRepositoryInterface']);
        });
    }
}
