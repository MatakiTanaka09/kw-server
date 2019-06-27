<?php

namespace KW\Infrastructure\Eloquents;

use Illuminate\Notifications\Notifiable;

class Book extends PivotUuid
{
    use Notifiable;
    /**
     * @var string
     */
    protected $table = 'books';

    /**
     * @var array
     */
    protected $fillable = ['user_parent_id', 'user_child_id', 'event_detail_id'];
}
