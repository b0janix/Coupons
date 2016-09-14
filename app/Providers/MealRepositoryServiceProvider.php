<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\MealRepository;

class MealRepositoryServiceProvider extends ServiceProvider
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
$this->app->bind('App\Repositories\MealRepositoryInterface', function($app)   {
        return new MealRepository($this->app['App\Meal']);});
    }
}
