<?php

namespace App\Models;

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
    public function eventMasters()
    {
        return $this->hasMany(EventMaster::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schoolAndMembers()
    {
        return $this->hasMany(SchoolAndMember::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function categoryMaster()
    {
        return $this->morphToMany(CategoryMaster::class, 'categorizable');
    }
}
