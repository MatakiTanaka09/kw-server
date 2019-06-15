<?php

namespace KW\Infrastructure\Eloquents;

class EventDetail extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'event_details';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventMaster()
    {
        return $this->belongsTo(EventMaster::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function books()
    {
        return $this->belongsToMany(
            UserParent::class,
            'books'
        )
            ->as('book')
            ->using(Book::class)
            ->withPivot('user_parent_id', 'user_child_id', 'event_detail_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'taggables',
            'event_detail_id',
            'tag_id'
        )->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function eventPr()
    {
        return $this->belongsTo(EventPr::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reviews()
    {
        return $this->belongsToMany(
            UserParent::class,
            'reviews'
        )
            ->as('review')
            ->using(Review::class)
            ->withPivot(['star_amount', 'comment'])
            ->withTimestamps();
    }
}
