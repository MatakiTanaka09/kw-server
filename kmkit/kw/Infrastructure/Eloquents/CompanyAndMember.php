<?php

namespace KW\Infrastructure\Eloquents;

/**
 * KW\Infrastructure\Eloquents\CompanyAndMember
 *
 * @property int $id
 * @property string $company_masters_id
 * @property int $company_admin_masters_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \KW\Infrastructure\Eloquents\CompanyAdminMaster $companyAdminMaster
 * @property-read \KW\Infrastructure\Eloquents\CompanyMaster $companyMaster
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CompanyAndMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CompanyAndMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CompanyAndMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CompanyAndMember whereCompanyAdminMastersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CompanyAndMember whereCompanyMastersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CompanyAndMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CompanyAndMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CompanyAndMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\KW\Infrastructure\Eloquents\CompanyAndMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompanyAndMember extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'company_and_members';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyMaster()
    {
        return $this->belongsTo(CompanyMaster::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyAdminMaster()
    {
        return $this->belongsTo(CompanyAdminMaster::class);
    }
}
