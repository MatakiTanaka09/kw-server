<?php

namespace KW\Application\Controllers\Common\EventPr;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\EventPr;

class EventPrBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventPrs()
    {
        return response()->json(EventPr::query()->select([
            'id',
            'pr'
        ])->get());
    }

    /**
     * @param Request $request
     * @param EventPr $eventPr
     */
    public function postEventPrs(Request $request, EventPr $eventPr)
    {
        $request->validate([
            'pr' => 'required'
        ]);
        $eventPr->pr         = $request->json('pr');
        $eventPr->save();
    }

    /**
     * @param $event_pr_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getEventPr($event_pr_id)
    {
        try {
            return EventPr::where('id', $event_pr_id)
                ->select([
                    'id',
                    'pr'
                ])->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param Request $request
     * @param $event_pr_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putEventPr(Request $request, $event_pr_id)
    {
        try {
            $eventPr = EventPr::where('id', $event_pr_id)->firstOrFail();
            $eventPr->pr = $request->json('pr');
            $eventPr->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $event_pr_id
     * @throws \Exception
     */
    public function deleteEventPr($event_pr_id)
    {
        EventPr::query()->where('id', '=', $event_pr_id)->delete();
    }


}
