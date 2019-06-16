<?php

namespace KW\Application\Resources\UserAccountInfo\User\UserParent;

use Illuminate\Http\Resources\Json\JsonResource;

class UserChild extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "sex_id" => $this->sex_id,
            "icon" => $this->icon,
            "first_kana" => $this->first_kana,
            "last_kana" => $this->last_kana
        ];
    }
}
