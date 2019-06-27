<?php

namespace KW\Infrastructure\Eloquents;

class PlaceRelation extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'place_relations';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];
}
