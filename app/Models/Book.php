<?php

namespace App\Models;

class Book extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'books';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userParent()
    {
        return $this->belongsTo(UserParent::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userChild()
    {
        return $this->belongsTo(UserChild::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventDetail()
    {
        return $this->belongsTo(EventDetail::class);
    }
}
