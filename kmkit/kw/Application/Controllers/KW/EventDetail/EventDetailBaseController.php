<?php
namespace KW\Application\Controllers\KW\EventDetail;

use App\Http\Controllers\Controller;
use KW\Application\Requests\EventDetail\EventDetail as EventDetailRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\EventDetail;
use Illuminate\Http\Request;
use KW\Domain\Models\EventDetail\EventDetailRepositoryInterface;

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
        $this->eventDetailRepo = $eventDetailRepo;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventDetails()
    {
        return response()->json(EventDetail::query()->select([
            'id',
            'event_master_id',
            'event_pr_id',
            'title',
            'detail',
            'started_at',
            'expired_at',
            'pub_state',
            'zip_code1',
            'zip_code2',
            'state',
            'city',
            'address1',
            'address2',
            'longitude',
            'latitude'
        ])->get());
    }

    /**
     * @param Request $request
     * @param EventDetail $eventDetail
     */
    public function postEventDetail(Request $request, EventDetail $eventDetail)
    {
        $request->validate([
            'event_master_id' => 'required',
            'event_pr_id' => 'required',
            'title'            => 'required',
            'detail'           => 'required',
            'started_at'       => 'required',
            'expired_at'       => 'required',
            'pub_state'        => 'required',
            'zip_code1'        => 'required',
            'zip_code2'        => 'required',
            'state'            => 'required',
            'city'             => 'required',
            'address1'         => 'required',
            'address2'         => 'required',
            'longitude'        => 'required',
            'latitude'         => 'required'
        ]);
        $eventDetail->event_master_id  = $request->json('event_master_id');
        $eventDetail->event_pr_id      = $request->json('event_pr_id');
        $eventDetail->title            = $request->json('title');
        $eventDetail->detail           = $request->json('detail');
        $eventDetail->started_at       = $request->json('started_at');
        $eventDetail->expired_at       = $request->json('expired_at');
        $eventDetail->pub_state        = $request->json('pub_state');
        $eventDetail->zip_code1        = $request->json('zip_code1');
        $eventDetail->zip_code2        = $request->json('zip_code2');
        $eventDetail->state            = $request->json('state');
        $eventDetail->city             = $request->json('city');
        $eventDetail->address1         = $request->json('address1');
        $eventDetail->address2         = $request->json('address2');
        $eventDetail->longitude        = $request->json('longitude');
        $eventDetail->latitude         = $request->json('latitude');
        $eventDetail->save();
//        $eventDetails = $this->eventDetailRepo->postEventDetail($request, $eventDetail);
//        return $eventDetails;
    }

    /**
     * @param $event_detail_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getEventDetail($event_detail_id)
    {
        try {
            return EventDetail::where('id', $event_detail_id)
                ->select([
                    'id',
                    'event_master_id',
                    'event_pr_id',
                    'title',
                    'detail',
                    'started_at',
                    'expired_at',
                    'pub_state',
                    'zip_code1',
                    'zip_code2',
                    'state',
                    'city',
                    'address1',
                    'address2',
                    'longitude',
                    'latitude'
                ])
                ->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param Request $request
     * @param $event_detail_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putEventDetail(Request $request, $event_detail_id)
    {
        try {
            $eventDetail = EventDetail::where('id', $event_detail_id)->firstOrFail();
            $eventDetail->event_master_id  = $request->json('event_master_id');
            $eventDetail->event_pr_id      = $request->json('event_pr_id');
            $eventDetail->title            = $request->json('title');
            $eventDetail->detail           = $request->json('detail');
            $eventDetail->started_at       = $request->json('started_at');
            $eventDetail->expired_at       = $request->json('expired_at');
            $eventDetail->pub_state        = $request->json('pub_state');
            $eventDetail->zip_code1        = $request->json('zip_code1');
            $eventDetail->zip_code2        = $request->json('zip_code2');
            $eventDetail->state            = $request->json('state');
            $eventDetail->city             = $request->json('city');
            $eventDetail->address1         = $request->json('address1');
            $eventDetail->address2         = $request->json('address2');
            $eventDetail->longitude        = $request->json('longitude');
            $eventDetail->latitude         = $request->json('latitude');
            $eventDetail->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $event_detail_id
     * @throws \Exception
     */
    public function deleteEventDetail($event_detail_id)
    {
        EventDetail::query()->where('id', '=', $event_detail_id)->delete();
    }
}
