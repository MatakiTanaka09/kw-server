<?php

namespace KW\Infrastructure\Eloquents;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * KW\Infrastructure\Eloquents\Review
 *
 * @property-read \KW\Infrastructure\Eloquents\EventDetail $eventDetail
 * @property-read \KW\Infrastructure\Eloquents\UserParent $userParent
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Review query()
 * @mixin \Eloquent
 */
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
