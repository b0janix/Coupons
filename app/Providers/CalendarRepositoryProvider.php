<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CalendarRepository;

class CalendarRepositoryProvider extends ServiceProvider
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
$this->app->bind('App\Repositories\CalendarRepositoryInterface', function($app)   {
        return new CalendarRepository($this->app['App\Calendar']);});
    }
}
