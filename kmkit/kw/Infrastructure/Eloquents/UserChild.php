<?php

namespace KW\Infrastructure\Eloquents;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function childParent()
    {
        return $this->hasOne(ChildParent::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sex()
    {
        return $this->belongsTo(Sex::class);
    }
}
