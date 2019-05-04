<?php

namespace App\Models;

class CompanyMaster extends BaseUuid
{
    /**
     * @var string
     */
    protected $table = 'company_masters';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function companyAndMembers()
    {
        return $this->hasMany(CompanyAndMember::class);
    }
}
