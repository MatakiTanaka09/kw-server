<?php

namespace KW\Infrastructure\Eloquents;

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
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventDetails()
    {
        return $this->hasMany(EventDetail::class);
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
    public function schoolMasters()
    {
        return $this->belongsToMany(
            SchoolMaster::class,
            'event_school_masters',
            'event_master_id',
            'school_master_id'
        )
            ->withPivot('id')
            ->withTimestamps();
    }
}
