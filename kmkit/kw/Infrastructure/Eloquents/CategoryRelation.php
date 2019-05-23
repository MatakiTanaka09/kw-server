<?php

namespace KW\Infrastructure\Eloquents;

class CategoryRelation extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'category_relations';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];
}
