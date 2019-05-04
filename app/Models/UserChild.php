<?php

namespace App\Models;

class UserChild extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'user_children';

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sex()
    {
        return $this->belongsTo(Sex::class);
    }
}
