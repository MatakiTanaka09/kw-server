<?php

namespace KW\Infrastructure\Eloquents;

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
    protected $guarded = [
    ];

    /**
     * @var array
     */
    protected $hidden = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userMaster()
    {
        return $this->belongsTo(UserMaster::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userChildren()
    {
        return $this->belongsToMany(
            UserChild::class,
            'child_parents',
            'user_parent_id',
            'user_child_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviews()
    {
        return $this->belongsToMany(
            EventDetail::class,
            'reviews'
        )
            ->as('review')
            ->using(Review::class)
            ->withPivot('star_amount', 'comment')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(
            EventDetail::class,
            'books'
        )
            ->as('book')
            ->using(Book::class)
            ->withPivot('user_parent_id', 'user_child_id', 'event_detail_id')
            ->withTimestamps();
    }
}
