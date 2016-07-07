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
        $this->loadViewsFrom( realpath( base_path( 'app/Clusters/RevisionerCluster/Resources/views' ) ), config( 'revisionermodule.module_name' ) );

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
        $moduleViewsNamespace = config( 'revisionermodule.views_name_space' ) . '::';
        $moduleRoutesNamespace = config( 'revisionermodule.routes_name_space' ) . '.';

        $revisionViewsNamespace = $moduleViewsNamespace . 'revisions.';
        $revisionRoutesNamespace = $moduleRoutesNamespace . 'revisions.';

        // Globals
        view()->share( 'revisionerClusterViews', $moduleViewsNamespace );
        view()->share( 'revisionerClusterLayout', config( 'revisionermodule.master_layout' ) );

        view()->share( 'revisionViews', $revisionViewsNamespace );
        view()->share( 'revisionRoutes', $revisionRoutesNamespace );
    }
}
