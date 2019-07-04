<?php

namespace  KW\Application\Resources\Book\User\Mail\booked;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolMaster extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "name"      => $this->name,
            "email"     => $this->email,
            "tel"       => $this->tel
        ];
    }
}
