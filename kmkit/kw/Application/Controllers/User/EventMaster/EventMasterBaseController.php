<?php
namespace KW\Application\Controllers\Common\EventMaster;

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
//        return response()->json(EventMaster::query()->select([
//            'id',
//            'school_master_id',
//            'category_master_id',
//            'title',
//            'detail'
//        ])->get());
        return EventMaster::with(['schoolMaster' => function($query) {
            $query->where('name', 'like', 'Pigeon.%');
        }])->get();
    }

    /**
     * @param Request $request
     * @param EventMaster $eventMaster
     */
    public function postEventMasters(Request $request, EventMaster $eventMaster)
    {
        $request->validate([
            'school_master_id'   => 'required',
            'category_master_id' => 'required',
            'title'              => 'required',
            'detail'             => 'required'
        ]);
        $eventMaster->school_master_id    = $request->json('school_master_id');
        $eventMaster->category_master_id  = $request->json('category_master_id');
        $eventMaster->title               = $request->json('title');
        $eventMaster->detail              = $request->json('detail');
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
                    'school_master_id',
                    'category_master_id',
                    'title',
                    'detail'
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
            $eventMaster->school_master_id   = $request->json('school_master_id');
            $eventMaster->category_master_id = $request->json('category_master_id');
            $eventMaster->title              = $request->json('title');
            $eventMaster->detail             = $request->json('detail');
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
