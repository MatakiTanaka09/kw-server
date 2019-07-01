<?php
namespace KW\Application\Controllers\KW\EventDetail;

use App\Http\Controllers\Controller;
use KW\Application\Requests\EventDetail\KW\EventDetail as EventDetailRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\EventDetail;
use Illuminate\Http\Response;
use KW\Domain\Models\EventDetail\EventDetailRepositoryInterface;
use KW\Application\Resources\EventDetail\User\detail\EventDetail as EventDetailResource;
use Carbon\Carbon;

class EventDetailBaseController extends Controller
{
    /**
     * @var EventDetailRepositoryInterface
     */
    private $eventDetailRepo;
    private $upload;

    /**
     * EventDetailBaseController constructor.
     * @param EventDetailRepositoryInterface $eventDetailRepo
     * @param UploadController $upload
     */
    public function __construct(
        EventDetailRepositoryInterface $eventDetailRepo,
        UploadController $upload
    ){
        $this->eventDetailRepo = $eventDetailRepo;
        $this->upload = $upload;
    }

    public function getEventDetails()
    {
        return EventDetail::paginate(15);
    }

    /**
     * @param EventDetailRequest $request
     * @param EventDetail $eventDetail
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEventDetail(EventDetailRequest $request, EventDetail $eventDetail)
    {
        $eventDetail->event_master_id = $request->json('event_master_id');
        $eventDetail->event_pr_id     = $request->json('event_pr_id');
        $eventDetail->started_at      = $request->json('started_at');
        $eventDetail->expired_at      = $request->json('expired_at');
        $eventDetail->pub_state       = $request->json('pub_state');
        $eventDetail->zip_code1       = $request->json('zip_code1');
        $eventDetail->zip_code2       = $request->json('zip_code2');
        $eventDetail->state           = $request->json('state');
        $eventDetail->city            = $request->json('city');
        $eventDetail->address1        = $request->json('address1');
        $eventDetail->address2        = $request->json('address2');
        $eventDetail->longitude       = $request->json('longitude');
        $eventDetail->latitude        = $request->json('latitude');
        $eventDetail->save();

        return EventDetailBaseController::receiveResponse($eventDetail);
    }

    public function getEventDetail($event_detail_id)
    {
        try {
            return new EventDetailResource(EventDetail::where('id', $event_detail_id)->firstOrFail());
        } catch (ModelNotFoundException $exception) {
            return EventDetailBaseController::errorMessage($exception);
        }
    }

    /**
     * @param EventDetailRequest $request
     * @param $event_detail_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putEventDetail(EventDetailRequest $request, $event_detail_id)
    {
        try {
            $eventDetail = EventDetail::where('id', $event_detail_id)->firstOrFail();
            $eventDetail->event_pr_id     = $request->json('event_pr_id');
            $eventDetail->started_at      = $request->json('started_at');
            $eventDetail->expired_at      = $request->json('expired_at');
            $eventDetail->pub_state       = $request->json('pub_state');
            $eventDetail->zip_code1       = $request->json('zip_code1');
            $eventDetail->zip_code2       = $request->json('zip_code2');
            $eventDetail->state           = $request->json('state');
            $eventDetail->city            = $request->json('city');
            $eventDetail->address1        = $request->json('address1');
            $eventDetail->address2        = $request->json('address2');
            $eventDetail->longitude       = $request->json('longitude');
            $eventDetail->latitude        = $request->json('latitude');
            $eventDetail->save();
        } catch (ModelNotFoundException $exception) {
            return EventDetailBaseController::errorMessage($exception);
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

    public function getEventMasterById($event_detail_id)
    {
        $eventDetail = EventDetail::where('id', $event_detail_id)->firstOrFail();
        return $eventDetail->eventMaster->id;
    }

    public function attachEventDetailToImage($eventDetail)
    {
        $eventDetail->images()->create([
            "url" => "https://kw-prod-bucket.s3-ap-northeast-1.amazonaws.com/event-details/1/btJTpNqRB5HFpmYwUq66dUWRbNXlItXCB5biQu6I.jpeg",
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    private static function receiveResponse($result)
    {
        return response()->json([
            'result' => 'ok',
            'data'   => $result
        ], Response::HTTP_OK);
    }

    private static function errorMessage($exception)
    {
        return response()
            ->json(['message' => $exception->getMessage()])
            ->header('Content-Type', 'application/json')
            ->setStatusCode(Response::HTTP_NOT_FOUND);
    }
}
