<?php

namespace KW\Application\Resources\Book\User\index;

use Illuminate\Http\Resources\Json\JsonResource;

class Image extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"  => $this->id,
            "url" => $this->url
        ];
    }
}
