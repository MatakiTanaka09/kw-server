<?php

namespace KW\Infrastructure\Eloquents;

/**
 * KW\Infrastructure\Eloquents\Book
 *
 * @property string $id
 * @property string $child_parent_id
 * @property string $event_detail_id
 * @property int $status
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \KW\Infrastructure\Eloquents\EventDetail $eventDetail
 * @property-read \KW\Infrastructure\Eloquents\ChildParent $childParent
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Book whereEventDetailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Book wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Book whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Book whereChildParentId($value)
 * @mixin \Eloquent
 */
class Book extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'books';

    /**
     * @var array
     */
    protected $fillable = ['child_parent_id', 'event_detail_id'];

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function userParent()
//    {
//        return $this->belongsTo(UserParent::class);
//    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function userChild()
//    {
//        return $this->belongsTo(UserChild::class);
//    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function eventDetail()
//    {
//        return $this->belongsTo(EventDetail::class);
//    }
//
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function childParent()
//    {
//        return $this->belongsTo(ChildParent::class);
//    }
}
