<?php

namespace KW\Application\Resources\Book\User\index;

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
            "id" => $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "url"=> $this->url,
            "tel"=> $this->tel,
            "icon"=> $this->icon
        ];
    }
}
