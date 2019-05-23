<?php

namespace KW\Infrastructure\Eloquents;

/**
 * KW\Infrastructure\Eloquents\UserChild
 *
 * @property string $id
 * @property string $user_parents_id
 * @property string $sex_id
 * @property string $icon
 * @property string $first_kana
 * @property string $last_kana
 * @property string $birth_day
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\Book[] $books
 * @property-read \KW\Infrastructure\Eloquents\Sex $sex
 * @property-read \KW\Infrastructure\Eloquents\UserParent $userParent
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild whereBirthDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild whereFirstKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild whereLastKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild whereSexesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserChild whereUserParentsId($value)
 * @mixin \Eloquent
 */
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

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
//     */
//    public function userParent()
//    {
//        return $this->belongsToMany(UserParent::class);
//    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
//     */
//    public function books()
//    {
//        return $this->belongsToMany(Book::class);
//    }

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
