<?php

namespace KW\Application\Resources\Book\User\index;

use Illuminate\Http\Resources\Json\JsonResource;
use KW\Application\Resources\Book\User\index\UserChild as UserChildResource;
use KW\Application\Resources\Book\User\index\EventMaster as EventMasterResource;
use KW\Application\Resources\Book\User\index\Tag as TagResource;
use KW\Application\Resources\Book\User\index\Image as ImageResource;
use KW\Application\Resources\Book\User\index\SchoolMaster as SchoolMasterResource;
use KW\Application\Resources\Book\User\index\CategoryMaster as CategoryMasterResource;

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
            "title"            => $this->title,
            "started_at"       => $this->started_at,
            "expired_at"       => $this->expired_at,
            "image"            => ImageResource::collection($this->images),
            "user_child"       => UserChildResource::collection($this->books),
            "event_master"     => new EventMasterResource($this->eventMaster),
            "school_master"    => SchoolMasterResource::collection($this->eventMaster->schoolMasters),
            "tag"              => TagResource::collection($this->tags),
            "category_master"  => CategoryMasterResource::collection($this->eventMaster->categoryMasters)
        ];
    }
}
