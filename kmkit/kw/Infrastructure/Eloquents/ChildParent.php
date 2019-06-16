<?php

namespace KW\Infrastructure\Eloquents;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChildParent extends Pivot
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
        return $this->belongsToMany(
            EventDetail::class,
            'books'
        )
            ->as('info')
            ->using(Book::class)
            ->withPivot(['status', 'price'])
            ->withTimestamps();
    }
}
