<?php

namespace KW\Infrastructure\Eloquents;

/**
 * KW\Infrastructure\Eloquents\CategoryMaster
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\EventDetail[] $eventDetails
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\SchoolMaster[] $schoolMasters
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CategoryMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CategoryMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CategoryMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CategoryMaster whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CategoryMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CategoryMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CategoryMaster whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CategoryMaster wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CategoryMaster whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CategoryMaster extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'category_masters';

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
}
