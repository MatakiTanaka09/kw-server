<?php

namespace KW\Infrastructure\Eloquents;

class EventSchoolMaster extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'event_school_masters';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function eventDetails()
    {
        return $this->hasMany(EventDetail::Class);
    }
}
