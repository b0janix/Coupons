<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserAuthenticator;

class UserAuthenticatorServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\UserAuthenticatorInterface', function($app)   {
return new UserAuthenticator($this->app['App\Repositories\UserRepositoryInterface']);});
    }
}
