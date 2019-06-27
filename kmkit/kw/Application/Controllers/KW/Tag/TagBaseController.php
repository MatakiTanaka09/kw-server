<?php

namespace KW\Application\Controllers\Common\Tag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\Tag;

class TagBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTags()
    {
        return response()->json(Tag::query()->select([
            'id',
            'name'
        ])->get());
    }

    /**
     * @param Request $request
     * @param Tag $tag
     */
    public function postTags(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $tag->name = $request->json('name');
        $tag->save();
    }

    /**
     * @param $tag_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getTag($tag_id)
    {
        try {
            return Tag::where('id', $tag_id)
                ->select([
                    'id',
                    'name'
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
     * @param $tag_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putTag(Request $request, $tag_id)
    {
        try {
            $tag = Tag::where('id', $tag_id)->firstOrFail();
            $tag->name     = $request->json('name');
            $tag->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $tag_id
     * @throws \Exception
     */
    public function deleteTag($tag_id)
    {
        Tag::query()->where('id', '=', $tag_id)->delete();
    }
}
