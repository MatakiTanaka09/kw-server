<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolAndMember extends Model
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
