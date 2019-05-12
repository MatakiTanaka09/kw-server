<?php

namespace KW\Infrastructure\Eloquents;

class EventPr extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'event_prs';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = ['id'];

    public function eventDetails()
    {
        return $this->hasMany(EventDetail::class);
    }
}
