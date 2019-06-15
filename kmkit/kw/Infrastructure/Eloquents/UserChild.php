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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userParents()
    {
        return $this->belongsToMany(
            UserParent::class,
            'child_parents',
            'user_child_id',
            'user_parent_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sex()
    {
        return $this->belongsTo(Sex::class);
    }
}
