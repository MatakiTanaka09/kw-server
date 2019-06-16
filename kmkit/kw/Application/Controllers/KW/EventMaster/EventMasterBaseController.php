<?php
namespace KW\Application\Controllers\KW\EventMaster;

use App\Http\Controllers\Controller;
use KW\Application\Requests\EventMaster\KW\EventMaster as EventMasterRequest;
use Illuminate\Http\Response;
use KW\Application\Requests\EventDetail\KW\Upload as UploadRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\EventMaster;
use Carbon\Carbon;

class EventMasterBaseController extends Controller
{
    /**
     * @var EventDetailRepositoryInterface
     */
    private $upload;

    /**
     * EventMasterBaseController constructor.
     * @param UploadController $upload
     */
    public function __construct(UploadController $upload)
    {
        $this->upload = $upload;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventMasters()
    {
        return response()->json(EventMaster::query()->select([
            'id',
            'title',
            'detail',
            'handing',
            'event_minutes',
            'target_min_age',
            'target_max_age',
            'parent_attendant',
            'price',
            'cancel_policy',
            'pub_state',
            'arrived_at',
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
     * @param EventMasterRequest $request
     * @param EventMaster $eventMaster
     * @return string
     */
    public function postEventMasters(EventMasterRequest $request, EventMaster $eventMaster)
    {
        $eventMaster->title            = $request->json('title');
        $eventMaster->detail           = $request->json('detail');
        $eventMaster->handing          = $request->json('handing');
        $eventMaster->event_minutes    = $request->json('event_minutes');
        $eventMaster->target_min_age   = $request->json('target_min_age');
        $eventMaster->target_max_age   = $request->json('target_max_age');
        $eventMaster->parent_attendant = $request->json('parent_attendant');
        $eventMaster->price            = $request->json('price');
        $eventMaster->cancel_policy    = $request->json('cancel_policy');
        $eventMaster->pub_state        = $request->json('pub_state');
        $eventMaster->arrived_at       = $request->json('arrived_at');
        $eventMaster->zip_code1        = $request->json('zip_code1');
        $eventMaster->zip_code2        = $request->json('zip_code2');
        $eventMaster->state            = $request->json('state');
        $eventMaster->city             = $request->json('city');
        $eventMaster->address1         = $request->json('address1');
        $eventMaster->address2         = $request->json('address2');
        $eventMaster->longitude        = $request->json('longitude');
        $eventMaster->latitude         = $request->json('latitude');
        $eventMaster->save();

        EventMasterBaseController::attachEventMasterToSchoolMaster($request, $eventMaster);
        EventMasterBaseController::attachEventMasterToCategoryMaster($request, $eventMaster);
        return EventMasterBaseController::receiveResponse($eventMaster);
    }

    /**
     * @param $event_master_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getEventMaster($event_master_id)
    {
        try {
            return EventMaster::where('id', $event_master_id)
                ->select([
                    'id',
                    'title',
                    'detail',
                    'handing',
                    'event_minutes',
                    'target_min_age',
                    'target_max_age',
                    'parent_attendant',
                    'price',
                    'cancel_policy',
                    'pub_state',
                    'arrived_at',
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
            return EventMasterBaseController::errorMessage($exception);
        }
    }

    /**
     * @param EventMasterRequest $request
     * @param $event_master_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putEventMaster(EventMasterRequest $request, $event_master_id)
    {
        try {
            $eventMaster = EventMaster::where('id', $event_master_id)->firstOrFail();
            $eventMaster->title            = $request->json('title');
            $eventMaster->detail           = $request->json('detail');
            $eventMaster->handing          = $request->json('handing');
            $eventMaster->event_minutes    = $request->json('event_minutes');
            $eventMaster->target_min_age   = $request->json('target_min_age');
            $eventMaster->target_max_age   = $request->json('target_max_age');
            $eventMaster->parent_attendant = $request->json('parent_attendant');
            $eventMaster->price            = $request->json('price');
            $eventMaster->cancel_policy    = $request->json('cancel_policy');
            $eventMaster->pub_state        = $request->json('pub_state');
            $eventMaster->arrived_at       = $request->json('arrived_at');
            $eventMaster->zip_code1        = $request->json('zip_code1');
            $eventMaster->zip_code2        = $request->json('zip_code2');
            $eventMaster->state            = $request->json('state');
            $eventMaster->city             = $request->json('city');
            $eventMaster->address1         = $request->json('address1');
            $eventMaster->address2         = $request->json('address2');
            $eventMaster->longitude        = $request->json('longitude');
            $eventMaster->latitude         = $request->json('latitude');
            $eventMaster->save();

            $this->updatePivotEventMasterToCategoryMaster($request, $eventMaster);

            return EventMasterBaseController::receiveResponse($eventMaster);
        } catch (ModelNotFoundException $exception) {
            return EventMasterBaseController::errorMessage($exception);
        }
    }

    /**
     * @param $event_master_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEventMaster($event_master_id)
    {
        $eventMaster = EventMaster::where('id', $event_master_id)->firstOrFail();
        $eventMaster->schoolMasters()->detach();
        $eventMaster->categoryMasters()->detach();
        $eventMaster->images()->delete();
        $eventMaster->delete();
        return EventMasterBaseController::receiveResponse($eventMaster);
    }

    public function attachEventMasterToImage(UploadRequest $request, $event_master_id)
    {
        $eventMaster = EventMaster::where('id', $event_master_id)->firstOrFail();
        $url = $this->upload->postEventDetailImage($request);
        foreach ($url as $u) {
            $eventMaster->images()->create([
                "url" => $u,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        return EventMasterBaseController::receiveResponse($url);
    }

    private static function attachEventMasterToSchoolMaster($request, $eventMaster)
    {
        $school_master_id = $request->school_master_id;
        $eventMaster->schoolMasters()->attach($school_master_id, [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    private static function attachEventMasterToCategoryMaster($request, $eventMaster)
    {
        $category_master_id = $request->category_master_id;
        $eventMaster->categoryMasters()->attach($category_master_id, [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    public function updatePivotEventMasterToCategoryMaster($request, $eventMaster)
    {
        $target_category_master = $eventMaster->categoryMasters;
        $category_master_id = $request->category_master_id;
        $eventMaster->categoryMasters()->updateExistingPivot($target_category_master, [
            'category_master_id' => $category_master_id,
            'updated_at'         => Carbon::now()
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
