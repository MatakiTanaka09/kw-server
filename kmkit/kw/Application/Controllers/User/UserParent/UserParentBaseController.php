<?php

namespace KW\Application\Controllers\User\UserParent;

use App\Http\Controllers\Controller;
use KW\Application\Requests\UserParent\User\UserAccount as UserAccountRequest;
use KW\Application\Requests\UserParent\User\UserParent as UserParentRequest;
use KW\Application\Resources\Book\User\index\Book as BookResource;
//use KW\Application\Resources\UserAccountInfo\User\UserParent\UserParent as UserParentResource;
//use KW\Application\Resources\UserAccountInfo\User\UserParent\UserChild as UserChildResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\UserParent;
use KW\Infrastructure\Eloquents\Book;
use Illuminate\Http\Response;
use Carbon\Carbon;
use DB;
use KW\Infrastructure\Eloquents\UserChild;
use KW\Application\Controllers\User\UserChild\UserChildBaseController;

class UserParentBaseController extends Controller
{
    /**
     * @param UserAccountRequest $request
     * @param UserParent $userParent
     * @return mixed
     */
    public function postUserParent(UserAccountRequest $request, UserParent $userParent)
    {
        $userParent->user_master_id = $request->json('parent.user_master_id');
        $userParent->sex_id         = $request->json('parent.sex_id');
        $userParent->icon           = $request->json('parent.icon');
        $userParent->full_name      = $request->json('parent.full_name');
        $userParent->full_kana      = $request->json('parent.full_kana');
        $userParent->tel            = $request->json('parent.tel');
        $userParent->zip_code1      = $request->json('parent.zip_code1');
        $userParent->zip_code2      = $request->json('parent.zip_code2');
        $userParent->state          = $request->json('parent.state');
        $userParent->city           = $request->json('parent.city');
        $userParent->address1       = $request->json('parent.address1');
        $userParent->address2       = $request->json('parent.address2');
        $userParent->save();

        return $userParent->id;
    }

    /**
     * @param $user_parent_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getUserParent($user_parent_id)
    {
        try {
            return UserParent::where('id', '=', $user_parent_id)
                ->select([
                    'id',
                    'user_master_id',
                    'sex_id',
                    'icon',
                    'full_name',
                    'full_kana',
                    'tel',
                    'zip_code1',
                    'zip_code2',
                    'state',
                    'city',
                    'address1',
                    'address2'
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
     * @param UserParentRequest $request
     * @param $user_parent_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putUserParent(UserParentRequest $request, $user_parent_id)
    {
        try {
            $userParent = UserParent::where('id', $user_parent_id)->firstOrFail();
            $userParent->sex_id    = $request->json('sex_id');
            $userParent->icon      = $request->json('icon');
            $userParent->full_name = $request->json('full_name');
            $userParent->full_kana = $request->json('full_kana');
            $userParent->tel       = $request->json('tel');
            $userParent->zip_code1 = $request->json('zip_code1');
            $userParent->zip_code2 = $request->json('zip_code2');
            $userParent->state     = $request->json('state');
            $userParent->city      = $request->json('city');
            $userParent->address1  = $request->json('address1');
            $userParent->address2  = $request->json('address2');
            $userParent->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $user_parent_id
     * @throws \Exception
     */
    public function deleteUserParent($user_parent_id)
    {
        $userParent = UserParent::query()->where('id', '=', $user_parent_id)->firstOrFail();
        $userParent->userChildren()->detach();
        $userParent->delete();
    }

    /**
     * @param $user_parent_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUserParentsChildren($user_parent_id)
    {
        try {
            $parent = UserParent::findOrFail($user_parent_id);
            $children = $parent->userChildren()->get();
            return compact('parent', 'children');

        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    public function getUserParentsBooks($user_parent_id)
    {
        try {
            $parent = UserParent::findOrFail($user_parent_id);
//            return $parent::with(["childParents.userChild"])->where("id", "=", $user_parent_id)->get();
            return $event_details = $parent->childParents()->get();
            $user_child = $parent->childParents()->get();
            return compact('event_details', 'user_child');
        } catch (ModelNotFoundException $exception) {
            return UserParentBaseController::errorMessage($exception);
        }
    }

    /**
     * @param $request
     * @param $userParent
     */
    public function attachUserParentToUserChild($request, $userParent)
    {
        $user_child_id = $request->user_child_id;
        $userParent->userChildren()->attach($user_child_id, [
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
