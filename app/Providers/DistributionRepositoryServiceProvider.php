<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\DistributionRepository;

class DistributionRepositoryServiceProvider extends ServiceProvider
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
$this->app->bind('App\Repositories\DistributionRepositoryInterface', function($app)   {
            return new DistributionRepository($this->app['App\Worker'],
                                              $this->app['App\Coupon'],
                                              $this->app['App\Department'],
                                              $this->app['App\NewMeal'],
                                              $this->app['App\Calendar'],
                                              $this->app['App\ProcessingTitle']
                                              );
    });
  }
}