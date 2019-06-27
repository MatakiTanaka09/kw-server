<?php

namespace KW\Application\Resources\Book\User\index;

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
            "first_kana" => $this->full_name,
            "full_kana" => $this->full_kana
        ];
    }
}
