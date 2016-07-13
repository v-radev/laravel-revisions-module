<?php

namespace App\Clusters\RevisionerCluster\Library\Traits;

use App\Clusters\RevisionerCluster\Models\Revision;

trait RevisionableModelTrait
{

    abstract public function fresh($with = []);

    abstract public function getDirty();


    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->revision();

            return false;
        });

        static::updating(function($model) {
            $model->revision();

            return false;
        });
    }

    protected function revision()
    {
        $changed = [];
        $before = $this->attributes;
        $isNew = $this->fresh() ? false : true;

        // We are updating an existing record, so get the changed data
        if ( !$isNew ) {
            $changed = $this->getDirty();
            $before = array_intersect_key($this->fresh()->toArray(), $changed);
        }

        $data = [
            'item_id' => $isNew ? null : $this->attributes['id'],
            'user_id' => \Auth::id(),
            'model'   => static::class,
            'before'  => $before,
            'after'   => $changed,
        ];

        Revision::create( $data );
    }
}
