<?php

namespace App\Models;

class Review extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'reveiws';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventDetail()
    {
        return $this->belongsTo(EventDetail::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userParent()
    {
        return $this->belongsTo(UserParent::class);
    }
}
