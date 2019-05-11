<?php

namespace KW\Infrastructure\Eloquents;

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
class Review extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'reveiws';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventDetail()
    {
        return $this->belongsTo(EventDetail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userParent()
    {
        return $this->belongsTo(UserParent::class);
    }
}
