<?php

$moduleRoutesNamespace = config( 'revisionermodule.routes_name_space' ) . '.';

Route::pattern('id', '[1-9][0-9]*');

Route::group( [ 'prefix' => 'dashboard', 'middleware' => [ 'web', 'auth' ] ], function () use ( $moduleRoutesNamespace ) {
    //
} );
