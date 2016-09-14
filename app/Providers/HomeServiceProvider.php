<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HomeService;

class HomeServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\HomeServiceInterface', function($app)   {
return new HomeService($this->app['App\Repositories\RoleRepositoryInterface']);});
    }
}
