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
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function eventSchoolMaster()
    {
        return $this->belongsTo(EventSchoolMaster::class, 'event_school_master_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function childParents()
    {
        return $this->belongsToMany(
            ChildParent::class,
            'books'
        )
            ->as('info')
            ->using(Book::class)
            ->withPivot(['status', 'price'])
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userParents()
    {
        return $this->belongsToMany(UserParent::class, 'reviews');
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
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
