<?php

namespace KW\Application\Resources\Book\User\index;

use Illuminate\Http\Resources\Json\JsonResource;
use KW\Application\Resources\Book\User\index\Book as BookResource;
use KW\Application\Resources\Book\User\index\EventMaster as EventMasterResource;
use KW\Application\Resources\Book\User\index\Tag as TagResource;
use KW\Application\Resources\Book\User\index\SchoolMaster as SchoolMasterResource;
use KW\Application\Resources\Book\User\index\CategoryMaster as CategoryMasterResource;

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
            "detail" => $this->detail,
            "handing" => $this->handing,
            "started_at" => $this->started_at,
            "expired_at" => $this->expired_at,
            "capacity_members"=> $this->capacity_members,
            "target_min_age"=> $this->target_min_age,
            "target_max_age"=> $this->target_max_age,
            "parent_attendant"=> $this->parent_attendant,
            "price"=> $this->price,
            "cancel_deadline"=> $this->cancel_deadline,
            "cancel_policy"=> $this->cancel_policy,
            "pub_state" => $this->pub_state,
            "arrived_at" => $this->arrived_at,
            "book" => new BookResource($this->info),
            "event_master"=> new EventMasterResource($this->eventMaster),
            "school_master" => SchoolMasterResource::collection($this->eventMaster->schoolMasters),
            "tag" => TagResource::collection($this->tags),
            "category" => CategoryMasterResource::collection($this->eventMaster->categoryMasters)
        ];
    }
}
