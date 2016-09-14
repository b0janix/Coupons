<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ProcessingTitleRepository;

class ProcessingTitleRepositoryServiceProvider extends ServiceProvider
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
$this->app->bind('App\Repositories\ProcessingTitleRepositoryInterface', function($app)   {
        return new ProcessingTitleRepository($this->app['App\ProcessingTitle']);});
    }
}
