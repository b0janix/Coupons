<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ConstructionSiteRepository;

class SiteRepositoryServiceProvider extends ServiceProvider
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
$this->app->bind('App\Repositories\ConstructionSiteRepositoryInterface', function($app)   {
            return new ConstructionSiteRepository($this->app['App\ConstructionSite']);
    });
  }
}