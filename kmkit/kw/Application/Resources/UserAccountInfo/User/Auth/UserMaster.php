<?php

namespace KW\Application\Resources\UserAccountInfo\User\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class UserMaster extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"    => $this->id,
            "email" => $this->email
        ];
    }
}
