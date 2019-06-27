<?php

namespace KW\Infrastructure\Eloquents;

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
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function categoryMasters()
    {
        return $this->morphToMany(
            CategoryMaster::class,
            'target',
            'category_relations',
            'target_id',
            'category_master_id',
            'id',
            'id',
            false
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function placeMasters()
    {
        return $this->morphToMany(
            PlaceMaster::class,
            'target',
            'place_relations',
            'target_id',
            'place_master_id',
            'id',
            'id',
            false
        );
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
