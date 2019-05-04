<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryMaster extends Model
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
        return $this->morphedByMany(SchoolMaster::class,'categorizable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function eventDetails()
    {
        return $this->morphedByMany(EventDetail::class,'categorizable');
    }
}
