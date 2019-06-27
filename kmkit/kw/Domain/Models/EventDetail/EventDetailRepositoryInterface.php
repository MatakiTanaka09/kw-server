<?php
declare(strict_types=1);

namespace KW\Domain\Models\EventDetail;

use KW\Domain\Exceptions\ModelNotFoundExeption;
use Illuminate\Support\Collection;
use KW\Application\Requests\EventDetail\EventDetail as EventDetailRequest;


interface EventDetailRepositoryInterface
{
    /**
     * @param string $eventDetailId
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function findById(string $eventDetailId);

    /**
     * @param EventDetailRequest $request
     * @param $eventDetail
     * @return Collection
     * @throws ModelNotFoundExeption
     */
    public function postEventDetail(EventDetailRequest $request, $eventDetail);

    /**
     * @param $eventPr
     * @return Collection
     * @throws ModelNotFoundExeption
     */
//    public function postEventPr($eventPr);

    /**
     * @param $images
     * @return Collection
     * @throws ModelNotFoundExeption
     */
    public function postImages($images);

    /**
     * @param $tags
     * @return Collection
     * @throws ModelNotFoundExeption
     */
//    public function postTags($tags);
}
