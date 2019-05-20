<?php

namespace KW\Infrastructure\Eloquents;

/**
 * KW\Infrastructure\Eloquents\UserParent
 *
 * @property string $id
 * @property int $user_master_id
 * @property string $sex_id
 * @property string $icon
 * @property string $full_name
 * @property string $full_kana
 * @property string $tel
 * @property string $zip_code1
 * @property string $zip_code2
 * @property string $state
 * @property string $city
 * @property string $address1
 * @property string $address2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\Book[] $books
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\Review[] $reviews
 * @property-read \KW\Infrastructure\Eloquents\Sex $sex
 * @property-read \Illuminate\Database\Eloquent\Collection|\KW\Infrastructure\Eloquents\UserChild[] $userChildren
 * @property-read \KW\Infrastructure\Eloquents\UserMaster $userMaster
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereFullKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereSexesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereUserMastersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereZipCode1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\UserParent whereZipCode2($value)
 * @mixin \Eloquent
 */
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
        return $this->belongsToMany(UserChild::class, 'child_parents', 'user_parent_id', 'user_child_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function eventDetails()
    {
        return $this->belongsToMany(EventDetail::class, 'reviews');
    }

//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
//     */
//    public function sex()
//    {
//        return $this->belongsTo(Sex::class);
//    }
}
