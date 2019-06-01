<?php
namespace KW\Application\Controllers\User\EventDetail;

use App\Http\Controllers\Controller;
use KW\Application\Requests\EventDetail\EventDetail as EventDetailRequest;
use KW\Domain\Models\EventDetail\EventDetailRepositoryInterface;
use KW\Application\Resources\EventDetail\User\detail\EventDetail as EventDetailResource;

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
     * @return \Illuminate\Support\Collection
     */
    public function getEventDetail($eventDetailId)
    {
        $eventDetail = $this->eventDetailRepo->findById($eventDetailId);
        return EventDetailResource::collection($eventDetail);
    }
}
