<?php

namespace KW\Infrastructure\Eloquents;

/**
 * KW\Infrastructure\Eloquents\SchoolMaster
 *
 * @property string $id
 * @property string $name
 * @property string $detail
 * @property string $email
 * @property string $url
 * @property string $tel
 * @property string $icon
 * @property string $zip_code1
 * @property string $zip_code2
 * @property string $state
 * @property string $city
 * @property string $address1
 * @property string $address2
 * @property float|null $longitude
 * @property float|null $latitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\CategoryMaster[] $categoryMaster
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\EventMaster[] $eventMasters
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\SchoolAndMember[] $schoolAndMembers
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereZipCode1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolMaster whereZipCode2($value)
 * @mixin \Eloquent
 */
class SchoolMaster extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'school_masters';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schoolAndMembers()
    {
        return $this->hasMany(SchoolAndMember::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function categoryMasters()
    {
        return $this->morphToMany(CategoryMaster::class, 'target', 'category_relations');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function eventMasters()
    {
        return $this->belongsToMany(
            EventMaster::class,
            'event_school_masters',
            'school_master_id',
            'event_master_id'
        )->withTimestamps();
    }
}
