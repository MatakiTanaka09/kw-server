<?php

namespace KW\Infrastructure\Eloquents;

class Image extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'images';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
