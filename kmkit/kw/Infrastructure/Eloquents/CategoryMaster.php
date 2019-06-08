<?php

namespace KW\Infrastructure\Eloquents;

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
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function schoolMasters()
    {
        return $this->morphedByMany(SchoolMaster::class, 'target', 'category_relations')
            ->withTimestamps()
            ->withPivot(['category_master_id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function eventMasters()
    {
        return $this->morphedByMany(EventMaster::class, 'target', 'category_relations')
            ->withTimestamps()
            ->withPivot(['category_master_id']);
    }
}
