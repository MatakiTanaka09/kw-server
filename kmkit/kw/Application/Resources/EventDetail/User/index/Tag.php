<?php

namespace KW\Application\Resources\EventDetail\User\index;

use Illuminate\Http\Resources\Json\JsonResource;

class Tag extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title"=> $this->name
        ];
    }
}
