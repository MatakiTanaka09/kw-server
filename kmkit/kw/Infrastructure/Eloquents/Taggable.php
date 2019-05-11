<?php

namespace KW\Infrastructure\Eloquents;

/**
 * KW\Infrastructure\Eloquents\Taggable
 *
 * @property int $id
 * @property int $tags_id
 * @property string $event_details_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \KW\Infrastructure\Eloquents\EventDetail $eventDetail
 * @property-read \KW\Infrastructure\Eloquents\Tag $tag
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Taggable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Taggable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Taggable query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Taggable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Taggable whereEventDetailsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Taggable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Taggable whereTagsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\Taggable whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Taggable extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'taggables';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];
}
