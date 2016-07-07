<?php

namespace App\Clusters\RevisionerCluster\Providers;

use Illuminate\Support\ServiceProvider;

class RevisionerClusterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes( [
            realpath( base_path( 'app/Clusters/RevisionerCluster/Resources/config.php' ) ) => config_path( 'revisionercluster.php' ),
        ] );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register( RouteServiceProvider::class );
        $this->app->register( ViewServiceProvider::class );
    }
}
