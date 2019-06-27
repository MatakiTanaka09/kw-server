<?php

namespace KW\Application\Resources\EventDetail\User\index;

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
            "id" => $this->id,
            "title"=> $this->title,
            "detail"=> $this->detail,
            "target_min_age" => $this->target_min_age,
            "target_max_age" => $this->target_max_age,
            "price" => $this->price
        ];
    }
}
