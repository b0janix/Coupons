<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CouponRepository;

class CouponRepositoryServiceProvider extends ServiceProvider
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
$this->app->bind('App\Repositories\CouponRepositoryInterface', function($app)   {
        return new CouponRepository($this->app['App\Coupon']);});
    }
}
