<?php

namespace KW\Application\Resources\Book\School\detail;

use Illuminate\Http\Resources\Json\JsonResource;
use KW\Application\Resources\Book\School\detail\EventMaster as EventMasterResource;
use KW\Application\Resources\Book\School\detail\SchoolMaster as SchoolMasterResource;
use KW\Application\Resources\Book\School\detail\Tag as TagResource;
use KW\Application\Resources\Book\School\detail\CategoryMaster as CategoryMasterResource;

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
            "started_at"=> $this->started_at,
            "expired_at"=> $this->expired_at,
            "capacity_members"=> $this->capacity_members,
            "event_minutes"=> $this->event_minutes,
            "target_min_age"=> $this->target_min_age,
            "target_max_age"=> $this->target_max_age,
            "parent_attendant"=> $this->parent_attendant,
            "price"=> $this->price,
            "pub_state"=> $this->pub_state,
            "arrived_at"=> $this->arrived_at,
            "event_master"=> new EventMasterResource($this->eventMaster),
            "school_master" => SchoolMasterResource::collection($this->eventMaster->schoolMasters),
            "tag" => TagResource::collection($this->tags),
            "category" => CategoryMasterResource::collection($this->eventMaster->categoryMasters)
        ];
    }
}
