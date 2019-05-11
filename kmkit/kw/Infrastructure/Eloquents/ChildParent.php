<?php

namespace KW\Infrastructure\Eloquents;

class ChildParent extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'child_parents';

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
        return $this->belongsToMany(EventDetail::class, 'books');
    }
}
