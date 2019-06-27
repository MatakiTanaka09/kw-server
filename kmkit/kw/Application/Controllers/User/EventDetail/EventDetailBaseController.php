<?php
namespace KW\Application\Controllers\User\EventDetail;

use App\Http\Controllers\Controller;
use KW\Domain\Models\EventDetail\EventDetailRepositoryInterface;
use KW\Application\Resources\EventDetail\User\detail\EventDetail as EventDetailResourceDetail;

class EventDetailBaseController extends Controller
{
    /**
     * @var EventDetailRepositoryInterface
     */
    private $eventDetailRepo;

    /**
     * EventDetailBaseController constructor.
     * @param EventDetailRepositoryInterface $eventDetailRepo
     */
    public function __construct(EventDetailRepositoryInterface $eventDetailRepo)
    {
        return $this->eventDetailRepo = $eventDetailRepo;
    }

    /**
     * @param $eventDetailId
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getEventDetail($eventDetailId)
    {
        $eventDetail = $this->eventDetailRepo->findById($eventDetailId);
        return EventDetailResourceDetail::collection($eventDetail);
    }
}
