<?php

namespace App\Models;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoryMaster()
    {
        return $this->belongsTo(CategoryMaster::class);
    }
}
