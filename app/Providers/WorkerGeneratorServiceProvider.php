<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WorkerGenerator;

class WorkerGeneratorServiceProvider extends ServiceProvider
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
        //
        $this->app->bind('App\Services\WorkerGeneratorInterface', function($app)   {
return new WorkerGenerator($this->app['App\Repositories\WorkerRepositoryInterface'],
                           $this->app['App\Repositories\DepartmentRepositoryInterface'],
                           $this->app['App\Validators\WorkerValidator']
    );
        });
    }
}
