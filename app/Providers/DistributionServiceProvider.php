<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DistributionService;

class DistributionServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\DistributionServiceInterface', function($app)   {
return new DistributionService($this->app['App\Repositories\WorkerRepositoryInterface'],
                               $this->app['App\Repositories\CouponRepositoryInterface']
                               );
        });
    }
}
