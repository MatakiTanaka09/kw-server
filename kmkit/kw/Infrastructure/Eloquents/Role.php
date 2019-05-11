<?php

namespace KW\Infrastructure\Eloquents;

class Role extends AppEloquent
{
    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function userMasters()
    {
        return $this->morphedByMany(UserMaster::class, 'role_relations');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function schoolAdminMasters()
    {
        return $this->morphedByMany(SchoolAdminMaster::class, 'role_relations');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function companyAdminMasters()
    {
        return $this->morphedByMany(CompanyAdminMaster::class, 'role_relations');
    }
}
