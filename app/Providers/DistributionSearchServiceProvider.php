<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DistributionSearchService;

class DistributionSearchServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\DistributionSearchServiceInterface', function($app)   {
return new DistributionSearchService($this->app['App\Repositories\DepartmentRepositoryInterface'],
                                     $this->app['App\Repositories\CouponRepositoryInterface']);
        });
    }
}
