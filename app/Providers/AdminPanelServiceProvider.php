<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AdminPanel;

class AdminPanelServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\AdminPanelInterface', function($app) {
return new AdminPanel ($this->app['App\Repositories\RoleRepositoryInterface'],
                       $this->app['App\Repositories\UserRepositoryInterface']);});
    }
}
