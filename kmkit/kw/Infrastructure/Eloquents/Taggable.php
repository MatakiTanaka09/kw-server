<?php

namespace KW\Infrastructure\Eloquents;

class Taggable extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'taggables';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];
}
