<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ConstructionSiteCreator;

class SiteCreatorServiceProvider extends ServiceProvider
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
$this->app->bind('App\Services\ConstructionSiteCreatorInterface', function($app)   {
            return new ConstructionSiteCreator($this->app['App\Validators\SiteValidator'],
                                               $this->app['App\Repositories\ConstructionSiteRepositoryInterface']
     );
    });
    }
}
