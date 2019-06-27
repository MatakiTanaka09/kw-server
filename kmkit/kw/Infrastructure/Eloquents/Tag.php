<?php

namespace KW\Infrastructure\Eloquents;

class Tag extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function eventDetails()
    {
        return $this->belongsToMany(
            EventDetail::class,
            'taggables',
            'tag_id',
            'event_detail_id'
        )->withTimestamps();
    }
}
