<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ForgotPassword;

class ForgotPasswordServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\ForgotPasswordInterface', function($app)   {
   return new ForgotPassword($this->app['App\Repositories\UserRepositoryInterface']);});
    }
}
