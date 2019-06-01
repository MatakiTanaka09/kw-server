<?php

namespace KW\Application\Resources\Book\User\index;

use Illuminate\Http\Resources\Json\JsonResource;
use KW\Application\Resources\Book\User\index\EventDetail as EventDetailResource;

class UserParent extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "user_master_id" => $this->user_master_id,
            "sex_id" => $this->sex_id,
            "icon" => $this->icon,
            "full_name" => $this->full_name,
            "full_kana" => $this->full_kana,
            "tel"=> $this->tel,
            "zip_code1"=> $this->zip_code1,
            "zip_code2"=> $this->zip_code2,
            "state"=> $this->state,
            "city"=> $this->city,
            "address1"=> $this->address1,
            "address2"=> $this->address2,
            "event_detail"=> EventDetailResource::collection($this->books),
//            "school_master" => SchoolMasterResource::collection($this->eventMaster->schoolMasters),
//            "tag" => TagResource::collection($this->tags),
//            "category" => CategoryMasterResource::collection($this->eventMaster->categoryMasters)
        ];
    }
}
