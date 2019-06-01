<?php

namespace KW\Application\Controllers\Common\Taggable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\Taggable;

class TaggableBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTaggables()
    {
        return response()->json(Taggable::query()->select([
            'id',
            'tag_id',
            'event_detail_id'
        ])->get());
    }

    /**
     * @param Request $request
     * @param Taggable $taggable
     */
    public function postTaggables(Request $request, Taggable $taggable)
    {
        $request->validate([
            'tag_id'          => 'required',
            'event_detail_id' => 'required'
        ]);
        $taggable->tag_id         = $request->json('tag_id');
        $taggable->event_detail_id = $request->json('event_detail_id');
        $taggable->save();
    }

    /**
     * @param $taggable_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getTaggable($taggable_id)
    {
        try {
            return Taggable::where('id', $taggable_id)
                ->select([
                    'id',
                    'tag_id',
                    'event_detail_id'
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
     * @param $taggable_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putTaggable(Request $request, $taggable_id)
    {
        try {
            $taggable = Taggable::where('id', $taggable_id)->firstOrFail();
            $taggable->tag_id          = $request->json('tag_id');
            $taggable->event_detail_id = $request->json('event_detail_id');
            $taggable->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $taggable_id
     * @throws \Exception
     */
    public function deleteTaggable($taggable_id)
    {
        Taggable::query()->where('id', '=', $taggable_id)->delete();
    }
}
