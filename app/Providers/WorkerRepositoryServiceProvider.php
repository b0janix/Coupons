<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\WorkerRepository;

class WorkerRepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Repositories\WorkerRepositoryInterface', function($app)   {
        return new WorkerRepository($this->app['App\Worker']);});
 }
}