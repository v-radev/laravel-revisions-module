<?php

namespace App\Clusters\RevisionerCluster\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ( !$this->app->routesAreCached() ) {
            require realpath( base_path( 'app/Clusters/RevisionerCluster/Resources/revisioner_cluster_routes.php' ) );
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
