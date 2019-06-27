<?php

namespace KW\Infrastructure\Repositories\Domain\Eloquent\EventDetail;

use KW\Domain\Exceptions\ModelNotFoundExeption;
use KW\Domain\Models\EventDetail\EventDetailRepositoryInterface;
use Illuminate\Http\JsonResponse;
use KW\Application\Requests\EventDetail\EventDetail as EventDetailRequest;
use KW\Infrastructure\Eloquents\EventDetail;

final class EloquentEventDetailRepository implements EventDetailRepositoryInterface
{
    /** @var EventDetail */
    private $eloquent;

    /**
     * EloquentEventDetailRepository constructor.
     * @param EventDetail $eloquent
     */
    public function __construct(EventDetail $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    /**
     * @param string $eventDetailId
     * @return JsonResponse
     */
    public function findById(string $eventDetailId)
    {
        try {
            return EventDetail::query()->where([
                ['id', '=', $eventDetailId],
                ['pub_state', '=', 0],
            ])->get();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param EventDetailRequest $req
     * @param $eventDetail
     * @return \Illuminate\Support\Collection
     */
    public function postEventDetail(EventDetailRequest $req, $eventDetail)
    {
        $eventDetail->event_master_id  = $req->json('event_master_id');
        $eventDetail->event_pr_id      = $req->json('event_pr_id');
        $eventDetail->title            = $req->json('title');
        $eventDetail->detail           = $req->json('detail');
        $eventDetail->started_at       = $req->json('started_at');
        $eventDetail->expired_at       = $req->json('expired_at');
        $eventDetail->pub_state        = $req->json('pub_state');
        $eventDetail->zip_code1        = $req->json('zip_code1');
        $eventDetail->zip_code2        = $req->json('zip_code2');
        $eventDetail->state            = $req->json('state');
        $eventDetail->city             = $req->json('city');
        $eventDetail->address1         = $req->json('address1');
        $eventDetail->address2         = $req->json('address2');
        $eventDetail->longitude        = $req->json('longitude');
        $eventDetail->latitude         = $req->json('latitude');
        $eventDetail->save();
        return $eventDetail->id;
    }

    /**
     * @param $images
     * @return Collection
     * @throws ModelNotFoundExeption
     */
    public function postImages($images)
    {

    }

    /**
     * @param EventDetailRequest $req, $tags
     * @return Collection
     * @throws ModelNotFoundExeption
     */
    public function postTags(EventDetailRequest $req, $tags)
    {
        return "";
    }
}
