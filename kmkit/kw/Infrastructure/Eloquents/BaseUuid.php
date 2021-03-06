<?php

namespace KW\Infrastructure\Eloquents;
use Webpatser\Uuid\Uuid;

abstract class BaseUuid extends AppEloquent
{
    protected $primaryKey = 'id';
    /**
     *  protected $keyType = 'string';
     */

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });
    }
}
