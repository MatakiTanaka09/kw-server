<?php

namespace KW\Application\Resources\Book\User\index;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->price,
            "status" => $this->status
        ];
    }
}
