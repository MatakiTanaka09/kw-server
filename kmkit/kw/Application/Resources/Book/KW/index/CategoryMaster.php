<?php

namespace KW\Application\Resources\Book\KW\index;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryMaster extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"       => $this->id,
            "name"     => $this->name,
            "color"    => $this->color,
            "filename" => $this->filename
        ];
    }
}
