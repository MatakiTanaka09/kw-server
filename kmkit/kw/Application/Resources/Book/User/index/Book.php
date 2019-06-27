<?php

namespace KW\Application\Resources\Book\User\index;

use Illuminate\Http\Resources\Json\JsonResource;
//use KW\Application\Resources\Book\User\index\BookPivot as BookPivotResource;
use KW\Application\Resources\Book\User\index\UserChild as UserChildResource;
use KW\Application\Resources\Book\User\index\EventMaster as EventMasterResource;
use KW\Application\Resources\Book\User\index\Tag as TagResource;
use KW\Application\Resources\Book\User\index\Image as ImageResource;
use KW\Application\Resources\Book\User\index\SchoolMaster as SchoolMasterResource;
use KW\Application\Resources\Book\User\index\CategoryMaster as CategoryMasterResource;
//BookPivotResource::collection()
class Book extends JsonResource
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
            "image"            => ImageResource::collection($this->eventMaster->images),
            "event_master"     => new EventMasterResource($this->eventMaster),
            "book"             => $this->books
        ];
    }
}
