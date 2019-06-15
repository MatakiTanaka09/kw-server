<?php

namespace KW\Application\Resources\EventDetail\User\detail;

use Illuminate\Http\Resources\Json\JsonResource;

class EventMaster extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"               => $this->id,
            "title"            => $this->title,
            "detail"           => $this->detail,
            'handing'          => $this->handing,
            'event_minutes'    => $this->event_minutes,
            'target_min_age'   => $this->target_min_age,
            'target_max_age'   => $this->target_max_age,
            'parent_attendant' => $this->parent_attendant,
            'price'            => $this->price,
            'cancel_policy'    => $this->cancel_policy,
            'pub_state'        => $this->pub_state,
            'arrived_at'       => $this->arrived_at,
            'zip_code1'        => $this->zip_code1,
            'zip_code2'        => $this->zip_code2,
            'state'            => $this->state,
            'city'             => $this->city,
            'address1'         => $this->address1,
            'address2'         => $this->address2,
            'longitude'        => $this->longitude,
            'latitude'         => $this->latitude,
        ];
    }
}
