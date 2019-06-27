<?php

namespace KW\Infrastructure\Eloquents;

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
