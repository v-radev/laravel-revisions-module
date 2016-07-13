<?php

namespace App\Clusters\RevisionerCluster\Models;

use App\Clusters\MainCluster\Models\MasterModel;

class Revision extends MasterModel
{

    protected $casts = [
        'revised'  => 'boolean',
        'approved' => 'boolean',
        'before'   => 'array',
        'after'    => 'array',
    ];

    public $fillable = [
        'item_id',
        'user_id',
        'model',
        'before',
        'after',
        'approved',
        'revised',
    ];


    public function user()
    {
        return $this->belongsTo( 'App\Clusters\AuthCluster\Models\User' );
    }

}
