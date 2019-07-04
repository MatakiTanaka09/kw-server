<?php

namespace  KW\Application\Resources\Book\User\Mail\booked;

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
            'handing'          => $this->handing,
            'price'            => $this->price,
        ];
    }
}
