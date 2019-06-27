<?php

namespace KW\Application\Resources\EventDetail\User\detail;

use Illuminate\Http\Resources\Json\JsonResource;
use KW\Application\Resources\EventDetail\User\detail\EventMaster as EventMasterResource;
use KW\Application\Resources\EventDetail\User\detail\Tag as TagResource;
use KW\Application\Resources\EventDetail\User\detail\Image as ImageResource;
use KW\Application\Resources\EventDetail\User\detail\SchoolMaster as SchoolMasterResource;
use KW\Application\Resources\EventDetail\User\detail\CategoryMaster as CategoryMasterResource;

class EventDetail extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"               => $this->id,
            "started_at"       => $this->started_at,
            "expired_at"       => $this->expired_at,
            "pub_state"        => $this->pub_state,
            "zip_code1"        => $this->zip_code1,
            "zip_code2"        => $this->zip_code2,
            "state"            => $this->state,
            "city"             => $this->city,
            "address1"         => $this->address1,
            "address2"         => $this->address2,
            "longitude"        => $this->longitude,
            "latitude"         => $this->latitude,
            "event_pr"         => $this->eventPr->pr,
            "event_master"     => new EventMasterResource($this->eventMaster),
            "school_master"    => SchoolMasterResource::collection($this->eventMaster->schoolMasters),
            "tag"              => TagResource::collection($this->tags),
            "category"         => CategoryMasterResource::collection($this->eventMaster->categoryMasters),
            "images"           => ImageResource::collection($this->eventMaster->images)
        ];
    }
}
