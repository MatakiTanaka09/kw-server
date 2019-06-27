<?php

namespace KW\Infrastructure\Eloquents;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Review extends Pivot
{
    /**
     * @var string
     */
    protected $table = 'reviews';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];
}
