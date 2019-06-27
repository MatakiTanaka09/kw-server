<?php

namespace KW\Application\Controllers\Common\ChildParent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\ChildParent;

class ChildParentBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChildParents()
    {
        return response()->json(ChildParent::query()->select([
            'id',
            'user_parent_id',
            'user_child_id'
        ])->get());
    }

    /**
     * @param Request $request
     * @param ChildParent $childParent
     */
    public function postChildParent(Request $request, ChildParent $childParent)
    {
        $request->validate([
            'user_parent_id' => 'required',
            'user_child_id'  => 'required'
        ]);
        $childParent->user_parent_id = $request->json('user_parent_id');
        $childParent->user_child_id  = $request->json('user_child_id');
        $childParent->save();
    }

    /**
     * @param $child_parent_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getChildParent($child_parent_id)
    {
        try {
            return ChildParent::where('id', $child_parent_id)
                ->select([
                    'id',
                    'user_parent_id',
                    'user_child_id'
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
     * @param $child_parent_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putChildParent(Request $request, $child_parent_id)
    {
        try {
            $childParent = ChildParent::where('id', $child_parent_id)->firstOrFail();
            $childParent->user_parent_id = $request->json('user_parent_id');
            $childParent->user_child_id  = $request->json('user_child_id');
            $childParent->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $child_parent_id
     * @throws \Exception
     */
    public function deleteChildParent($child_parent_id)
    {
        ChildParent::query()->where('id', '=', $child_parent_id)->delete();
    }
}
