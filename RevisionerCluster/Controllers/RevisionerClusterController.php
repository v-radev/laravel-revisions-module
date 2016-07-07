<?php

namespace App\Clusters\RevisionerCluster\Controllers;

use App\Clusters\MainCluster\Controllers\MasterController;

abstract class RevisionerClusterController extends MasterController
{

    public $views = 'revisionerCluster::';


    public function view( $name, $data = [] )
    {
        return view( $this->views . $name, $data );
    }
}
