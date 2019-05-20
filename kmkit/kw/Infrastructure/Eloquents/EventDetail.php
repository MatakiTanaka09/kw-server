<?php

namespace KW\Infrastructure\Eloquents;

/**
 * KW\Infrastructure\Eloquents\EventDetail
 *
 * @property string $id
 * @property string $event_master_id
 * @property int $event_pr_id
 * @property string $title
 * @property string $detail
 * @property string $handing
 * @property string $started_at
 * @property string $expired_at
 * @property int $capacity_members
 * @property int $event_minutes
 * @property string $target_min_age
 * @property string $target_max_age
 * @property int $parent_attendant
 * @property int $price
 * @property string $cancel_policy
 * @property string $cancel_deadline
 * @property int $pub_state
 * @property string $arrived_at
 * @property string|null $zip_code1
 * @property string|null $zip_code2
 * @property string $state
 * @property string $city
 * @property string $address1
 * @property string|null $address2
 * @property float|null $longitude
 * @property float|null $latitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\Book[] $books
 * @property-read \KW\Infrastructure\Eloquents\EventMaster $eventMaster
 * @property-read \KW\Infrastructure\Eloquents\EventPr $eventPr
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\Review[] $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\Tag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereHanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereCancelPolicy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereArrivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereCancelDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereCapacityMembers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereEventMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereEventMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereParentAttendant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereEventPrId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail wherePubState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereTargetMaxAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereTargetMinAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereZipCode1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventDetail whereZipCode2($value)
 * @mixin \Eloquent
 */
class EventDetail extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'event_details';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventMaster()
    {
        return $this->belongsTo(EventMaster::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function childParents()
    {
        return $this->belongsToMany(ChildParent::class, 'books');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userParents()
    {
        return $this->belongsToMany(UserParent::class, 'reviews');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'taggables', 'event_detail_id', 'tag_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'target');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventPr()
    {
        return $this->belongsTo(EventPr::class);
    }
}
