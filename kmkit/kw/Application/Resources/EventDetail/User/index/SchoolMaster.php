<?php

namespace KW\Application\Resources\EventDetail\User\index;

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
            "detail"=> $this->detail,
            "email"=> $this->email,
            "url"=> $this->url,
            "tel"=> $this->tel,
            "icon"=> $this->icon,
            "zip_code1"=> $this->zip_code1,
            "zip_code2"=> $this->zip_code2,
            "state"=> $this->state,
            "city"=> $this->city,
            "address1"=> $this->address1,
            "address2"=> $this->address2,
            "longitude"=> $this->longitude,
            "latitude"=> $this->latitude
        ];
    }
}
