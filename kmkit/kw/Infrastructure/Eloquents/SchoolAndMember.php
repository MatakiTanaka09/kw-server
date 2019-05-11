<?php

namespace KW\Infrastructure\Eloquents;

/**
 * KW\Infrastructure\Eloquents\SchoolAndMember
 *
 * @property int $id
 * @property string $school_masters_id
 * @property int $school_admin_masters_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \KW\Infrastructure\Eloquents\SchoolAdminMaster $schoolAdminMaster
 * @property-read \KW\Infrastructure\Eloquents\SchoolMaster $schoolMaster
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolAndMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolAndMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolAndMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolAndMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolAndMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolAndMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolAndMember whereSchoolAdminMastersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolAndMember whereSchoolMastersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\SchoolAndMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SchoolAndMember extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'school_and_members';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolMaster()
    {
        return $this->belongsTo(SchoolMaster::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function schoolAdminMaster()
    {
        return $this->belongsTo(SchoolAdminMaster::class);
    }
}
