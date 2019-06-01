<?php

namespace KW\Application\Resources\Book\School\index;

use Illuminate\Http\Resources\Json\JsonResource;
use KW\Application\Resources\Book\School\index\EventMaster as EventMasterResource;
use KW\Application\Resources\Book\School\index\SchoolMaster as SchoolMasterResource;
use KW\Application\Resources\Book\School\index\Tag as TagResource;
use KW\Application\Resources\Book\School\index\CategoryMaster as CategoryMasterResource;

class Book extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title"=> $this->title,
            "detail"=> $this->detail,
            "handing"=> $this->handing,
            "started_at"=> $this->started_at,
            "expired_at"=> $this->expired_at,
            "capacity_members"=> $this->capacity_members,
            "event_minutes"=> $this->event_minutes,
            "target_min_age"=> $this->target_min_age,
            "target_max_age"=> $this->target_max_age,
            "parent_attendant"=> $this->parent_attendant,
            "price"=> $this->price,
            "cancel_deadline"=> $this->cancel_deadline,
            "cancel_policy"=> $this->cancel_policy,
            "pub_state"=> $this->pub_state,
            "arrived_at"=> $this->arrived_at,
            "zip_code1"=> $this->zip_code1,
            "zip_code2"=> $this->zip_code2,
            "state"=> $this->state,
            "city"=> $this->city,
            "address1"=> $this->address1,
            "address2"=> $this->address2,
            "longitude"=> $this->longitude,
            "latitude"=> $this->latitude,
            "event_pr"=> $this->eventPr->pr,
            "event_master"=> new EventMasterResource($this->eventMaster),
            "school_master" => SchoolMasterResource::collection($this->eventMaster->schoolMasters),
            "tag" => TagResource::collection($this->tags),
            "category" => CategoryMasterResource::collection($this->eventMaster->categoryMasters)
        ];
    }
}
