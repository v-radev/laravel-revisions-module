<?php

namespace App\Clusters\RevisionerCluster\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom( realpath( base_path( 'app/Clusters/RevisionerCluster/Resources/views' ) ), config( 'revisionercluster.module_name' ) );

        $this->loadGlobalVariables();
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

    protected function loadGlobalVariables()
    {
        $moduleViewsNamespace = config( 'revisionercluster.views_name_space' ) . '::';
        $moduleRoutesNamespace = config( 'revisionercluster.routes_name_space' ) . '.';

        $revisionViewsNamespace = $moduleViewsNamespace . 'revisions.';
        $revisionRoutesNamespace = $moduleRoutesNamespace . 'revisions.';

        // Globals
        view()->share( 'revisionerClusterViews', $moduleViewsNamespace );
        view()->share( 'revisionerClusterLayout', config( 'revisionercluster.master_layout' ) );

        view()->share( 'revisionViews', $revisionViewsNamespace );
        view()->share( 'revisionRoutes', $revisionRoutesNamespace );
    }
}
