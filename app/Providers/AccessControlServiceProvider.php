<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AccessControl;

class AccessControlServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\AccessControlInterface', function($app)   {
return new AccessControl($this->app['App\Repositories\RoleRepositoryInterface']);});
    }
}
