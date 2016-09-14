<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\RoleRepository;

class RoleRepositoryServiceProvider extends ServiceProvider
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
$this->app->bind('App\Repositories\RoleRepositoryInterface', function($app)   {
        return new RoleRepository($this->app['App\Role']);});
    }
}
