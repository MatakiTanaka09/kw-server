<?php

namespace App\Models;

class UserParent extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'user_parents';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userMaster()
    {
        return $this->belongsTo(UserMaster::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userChildren()
    {
        return $this->hasMany(UserChild::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviews()
    {
        return $this->belongsToMany(Review::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sex()
    {
        return $this->belongsTo(Sex::class);
    }
}
