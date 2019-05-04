<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sex extends Model
{
    /**
     * @var string
     */
    protected $table = 'sexes';

    /**
     * 全属性を複数代入可能
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userParent()
    {
        return $this->hasOne(UserParent::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userChild()
    {
        return $this->hasOne(UserChild::class);
    }
}
