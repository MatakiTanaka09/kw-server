<?php

namespace KW\Application\Resources\EventDetail\User\index;

use Illuminate\Http\Resources\Json\JsonResource;
use KW\Application\Resources\EventDetail\User\index\EventMaster as EventMasterResource;
use KW\Application\Resources\EventDetail\User\index\Tag as TagResource;
use KW\Application\Resources\EventDetail\User\index\SchoolMaster as SchoolMasterResource;
use KW\Application\Resources\EventDetail\User\index\CategoryMaster as CategoryMasterResource;

class EventDetail extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "started_at" => $this->started_at,
            "expired_at" => $this->expired_at,
            "target_min_age"=> $this->target_min_age,
            "target_max_age"=> $this->target_max_age,
            "price"=> $this->price,
            "pub_state" => $this->pub_state,
            "event_master"=> new EventMasterResource($this->eventMaster),
            "school_master" => SchoolMasterResource::collection($this->eventMaster->schoolMasters),
            "tag" => TagResource::collection($this->tags),
            "category" => CategoryMasterResource::collection($this->eventMaster->categoryMasters)
        ];
    }
}
