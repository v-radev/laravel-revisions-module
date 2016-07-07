<?php

$moduleRoutesNamespace = config( 'revisionercluster.routes_name_space' ) . '.';

Route::pattern('id', '[1-9][0-9]*');

Route::group( [ 'prefix' => 'dashboard', 'middleware' => [ 'web', 'auth' ] ], function () use ( $moduleRoutesNamespace ) {
    Route::resource(
        'revisions',
        'App\Clusters\RevisionerCluster\Controllers\RevisionsController',
        [
            'names'  =>
                [
                    'index'   => $moduleRoutesNamespace . 'revisions.index',
                    'show'    => $moduleRoutesNamespace . 'revisions.show',
                    'update'  => $moduleRoutesNamespace . 'revisions.update',
                    'destroy' => $moduleRoutesNamespace . 'revisions.destroy',
                ],
            'except' => [ 'create', 'edit', 'store' ]
        ]
    );
} );
