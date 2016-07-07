<?php

namespace App\Clusters\RevisionerCluster\Models;

use App\Clusters\MainCluster\Models\MasterModel;

class Revision extends MasterModel
{

    protected $casts = [
        'approved' => 'boolean'
    ];

    public $fillable = [
        'item_id',
        'user_id',
        'model',
        'before',
        'after',
        'approved',
    ];

}
