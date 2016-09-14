<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ProcessingService;

class ProcessingServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\ProcessingServiceInterface', function($app)   {
return new ProcessingService(
                               $this->app['App\Repositories\ConstructionSiteRepositoryInterface'],
                               $this->app['App\Repositories\WorkerRepositoryInterface'],
                               $this->app['App\Repositories\CouponRepositoryInterface'],
                               $this->app['App\Validators\CouponDistributionValidator'],
                               $this->app['App\Repositories\DepartmentRepositoryInterface'],
                               $this->app['App\Repositories\ProcessingTitleRepositoryInterface'],
                               $this->app['App\Repositories\NewMealRepositoryInterface'],
                               $this->app['App\Repositories\CalendarRepositoryInterface']
            );
        });
    }
}
