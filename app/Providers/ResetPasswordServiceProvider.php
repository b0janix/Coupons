<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ResetPassword;

class ResetPasswordServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\ResetPasswordInterface', function($app)   {
      return new ResetPassword(
                             $this->app['App\Repositories\UserRepositoryInterface']);});
    }
}
