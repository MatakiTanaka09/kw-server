<?php

namespace KW\Infrastructure\Eloquents;

class RoleRelation extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];
}
