<?php

namespace KW\Application\Resources\Book\User\Mail\booked;

use Illuminate\Http\Resources\Json\JsonResource;
use KW\Application\Resources\Book\User\Mail\booked\EventMaster as EventMasterResource;
use KW\Application\Resources\Book\User\Mail\booked\SchoolMaster as SchoolMasterResource;

class EventDetail extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "started_at"       => $this->started_at,
            "pub_state"        => $this->pub_state,
            "zip_code1"        => $this->zip_code1,
            "zip_code2"        => $this->zip_code2,
            "state"            => $this->state,
            "city"             => $this->city,
            "address1"         => $this->address1,
            "address2"         => $this->address2,
            "event_master"     => new EventMasterResource($this->eventMaster),
            "school_master"    => SchoolMasterResource::collection($this->eventMaster->schoolMasters)
        ];
    }
}
