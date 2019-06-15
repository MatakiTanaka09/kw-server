<?php

namespace KW\Infrastructure\Eloquents;

class PlaceMaster extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'place_masters';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function schoolMasters()
    {
        return $this->morphedByMany(SchoolMaster::class, 'target', 'place_relations')
            ->withTimestamps()
            ->withPivot(['place_master_id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function eventMasters()
    {
        return $this->morphedByMany(EventMaster::class, 'target', 'place_relations')
            ->withTimestamps()
            ->withPivot(['place_master_id']);
    }
}
