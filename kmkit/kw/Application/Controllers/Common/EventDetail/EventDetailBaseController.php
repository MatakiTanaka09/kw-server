<?php
namespace KW\Application\Controllers\Common\EventDetail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\EventDetail;

class EventDetailBaseController extends Controller
{
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
            'handing',
            'started_at',
            'expired_at',
            'capacity_members',
            'event_minutes',
            'target_min_age',
            'target_max_age',
            'parent_attendant',
            'price',
            'cancel_policy',
            'cancel_deadline',
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
     * @param EventDetail $eventDetail
     */
    public function postEventDetail(Request $request, EventDetail $eventDetail)
    {
        $request->validate([
            'event_master_id'  => 'required',
            'event_pr_id'      => 'required',
            'title'            => 'required',
            'detail'           => 'required',
            'handing'          => 'required',
            'started_at'       => 'required',
            'expired_at'       => 'required',
            'capacity_members' => 'required',
            'event_minutes'    => 'required',
            'target_min_age'   => 'required',
            'target_max_age'   => 'required',
            'parent_attendant' => 'required',
            'price'            => 'required',
            'cancel_policy'    => 'required',
            'cancel_deadline'  => 'required',
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
        $eventDetail->event_master_id  = $request->json('event_master_id');
        $eventDetail->event_pr_id      = $request->json('event_pr_id');
        $eventDetail->title            = $request->json('title');
        $eventDetail->detail           = $request->json('detail');
        $eventDetail->handing          = $request->json('handing');
        $eventDetail->started_at       = $request->json('started_at');
        $eventDetail->expired_at       = $request->json('expired_at');
        $eventDetail->capacity_members = $request->json('capacity_members');
        $eventDetail->event_minutes    = $request->json('event_minutes');
        $eventDetail->target_min_age   = $request->json('target_min_age');
        $eventDetail->target_max_age   = $request->json('target_max_age');
        $eventDetail->parent_attendant = $request->json('parent_attendant');
        $eventDetail->price            = $request->json('price');
        $eventDetail->cancel_policy    = $request->json('cancel_policy');
        $eventDetail->cancel_deadline  = $request->json('cancel_deadline');
        $eventDetail->pub_state        = $request->json('pub_state');
        $eventDetail->arrived_at       = $request->json('arrived_at');
        $eventDetail->zip_code1        = $request->json('zip_code1');
        $eventDetail->zip_code2        = $request->json('zip_code2');
        $eventDetail->state            = $request->json('state');
        $eventDetail->city             = $request->json('city');
        $eventDetail->address1         = $request->json('address1');
        $eventDetail->address2         = $request->json('address2');
        $eventDetail->longitude        = $request->json('longitude');
        $eventDetail->latitude         = $request->json('latitude');
        $eventDetail->save();
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
                    'handing',
                    'started_at',
                    'expired_at',
                    'capacity_members',
                    'event_minutes',
                    'target_min_age',
                    'target_max_age',
                    'parent_attendant',
                    'price',
                    'cancel_policy',
                    'cancel_deadline',
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
            $eventDetail->handing          = $request->json('handing');
            $eventDetail->started_at       = $request->json('started_at');
            $eventDetail->expired_at       = $request->json('expired_at');
            $eventDetail->capacity_members = $request->json('capacity_members');
            $eventDetail->event_minutes    = $request->json('event_minutes');
            $eventDetail->target_min_age   = $request->json('target_min_age');
            $eventDetail->target_max_age   = $request->json('target_max_age');
            $eventDetail->parent_attendant = $request->json('parent_attendant');
            $eventDetail->price            = $request->json('price');
            $eventDetail->cancel_policy    = $request->json('cancel_policy');
            $eventDetail->cancel_deadline  = $request->json('cancel_deadline');
            $eventDetail->pub_state        = $request->json('pub_state');
            $eventDetail->arrived_at       = $request->json('arrived_at');
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
