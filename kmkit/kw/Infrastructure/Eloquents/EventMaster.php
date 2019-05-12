<?php

namespace KW\Infrastructure\Eloquents;

/**
 * KW\Infrastructure\Eloquents\EventMaster
 *
 * @property string $id
 * @property string $school_master_id
 * @property string $category_master_id
 * @property string $title
 * @property string $detail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \KW\Infrastructure\Eloquents\CategoryMaster $categoryMaster
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\EventDetail[] $eventDetails
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventMaster whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventMaster whereSchoolMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventMaster whereCategoryMasterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventMaster whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\EventMaster whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventMaster extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'event_masters';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventDetails()
    {
        return $this->hasMany(EventDetail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryMaster()
    {
        return $this->belongsTo(CategoryMaster::class);
    }
}
