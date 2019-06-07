<?php
namespace KW\Application\Controllers\KW\EventMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\EventMaster;

class EventMasterBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventMasters()
    {
        return response()->json(EventMaster::query()->select([
            'id',
            'event_master_id',
            'event_pr_id',
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
     * @param Request $request
     * @param EventMaster $eventMaster
     */
    public function postEventMasters(Request $request, EventMaster $eventMaster)
    {
        $request->validate([
            'event_master_id'  => 'required',
            'event_pr_id'      => 'required',
            'title'            => 'required',
            'detail'           => 'required',
            'handing'          => 'required',
            'event_minutes'    => 'required',
            'target_min_age'   => 'required',
            'target_max_age'   => 'required',
            'parent_attendant' => 'required',
            'price'            => 'required',
            'cancel_policy'    => 'required',
            'pub_state'        => 'required',
            'arrived_at'       => 'required',
            'zip_code1'        => 'required',
            'zip_code2'        => 'required',
            'state'            => 'required',
            'city'             => 'required',
            'address1'         => 'required',
            'address2'         => 'required',
            'longitude'        => 'required',
            'latitude'         => 'required'
        ]);
        $eventMaster->event_master_id            = $request->json('event_master_id');
        $eventMaster->event_pr_id           = $request->json('event_pr_id');
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
                    'event_master_id',
                    'event_pr_id',
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
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param Request $request
     * @param $event_master_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putEventMaster(Request $request, $event_master_id)
    {
        try {
            $eventMaster = EventMaster::where('id', $event_master_id)->firstOrFail();
            $eventMaster->event_master_id            = $request->json('event_master_id');
            $eventMaster->event_pr_id           = $request->json('event_pr_id');
            $eventMaster->title              = $request->json('title');
            $eventMaster->detail             = $request->json('detail');
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
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $event_master_id
     * @throws \Exception
     */
    public function deleteEventMaster($event_master_id)
    {
        EventMaster::query()->where('id', '=', $event_master_id)->delete();
    }
}
