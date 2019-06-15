<?php

namespace KW\Application\Controllers\User\UserParent;

use App\Http\Controllers\Controller;
use KW\Application\Requests\UserParent\User\UserParent as UserParentRequest;
use KW\Application\Resources\Book\User\index\Book as BookTestResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\UserParent;
use Carbon\Carbon;

class UserParentBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserParents()
    {
        return response()->json(UserParent::query()->select([
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
            'address2',
            'created_at',
            'updated_at'
        ])->get());
    }

    /**
     * @param UserParentRequest $request
     * @param UserParent $userParent
     */
    public function postUserParent(UserParentRequest $request, UserParent $userParent)
    {
        $userParent->user_master_id = $request->json('user_master_id');
        $userParent->sex_id         = $request->json('sex_id');
        $userParent->icon           = $request->json('icon');
        $userParent->full_name      = $request->json('full_name');
        $userParent->full_kana      = $request->json('full_kana');
        $userParent->tel            = $request->json('tel');
        $userParent->zip_code1      = $request->json('zip_code1');
        $userParent->zip_code2      = $request->json('zip_code2');
        $userParent->state          = $request->json('state');
        $userParent->city           = $request->json('city');
        $userParent->address1       = $request->json('address1');
        $userParent->address2       = $request->json('address2');
        $userParent->save();
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
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function getUserParentsChildren($user_parent_id)
    {
        try {
            return UserParent::findOrFail($user_parent_id)
                ->userChildren()
                ->get();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $user_parent_id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getUserParentsBooks($user_parent_id)
    {
        try {
            $bookedEventDetail = EventDetail::whereHas("books", function($query) use($user_parent_id) {
                $query->where("user_parent_id", "=", $user_parent_id);
            })->get();
            return BookTestResource::collection($bookedEventDetail);
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
            $result
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
