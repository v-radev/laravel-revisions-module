<?php

namespace App\Clusters\PostsCluster\Models;

use App\Clusters\MainCluster\Models\MasterModel;

class Revision extends MasterModel
{

    public $fillable = [
        'item_id',
        'user_id',
        'model',
        'before',
        'after',
    ];

}
