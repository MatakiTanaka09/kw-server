<?php

namespace KW\Application\Controllers\User\UserParent;

use App\Http\Controllers\Controller;
use KW\Application\Requests\UserParent\User\UserParent as UserParentRequest;
use KW\Application\Resources\Book\User\index\Book as BookTestResource;
use KW\Application\Resources\UserAccountInfo\User\UserParent\UserParent as UserParentResource;
use KW\Application\Resources\UserAccountInfo\User\UserParent\UserChild as UserChildResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\UserParent;
use Illuminate\Http\Response;
use Carbon\Carbon;
use DB;
use KW\Infrastructure\Eloquents\UserChild;

class UserParentBaseController extends Controller
{
    /**
     * @param UserParentRequest $request
     * @param UserParent $userParent
     * @return \Illuminate\Http\JsonResponse
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

        return UserParentBaseController::receiveResponse($userParent);
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
            return UserChildResource::collection(UserParent::findOrFail($user_parent_id)
                ->userChildren()
                ->get());
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
//            $userParent = UserParent::findOrFail($user_parent_id)->books()->get();
//            $eventDetail = UserParent::with("userChildren")
//                ->whereHas("books")
//                ->get();
//            return $userParent;
//            return DB::table("user_parents")
//                ->join("books", function($join) {
//                    $join->on("user_parents.id", "=", "books.user_parent_id");
//                })
//                ->join("child_parents", function($join) {
//                    $join->on("user_parents.id", "=", "child_parents.user_parent_id");
//                })
//                ->get();
//            return $eventDetail = SchoolMaster::findOrFail("a4bb4610-8f4a-11e9-a311-29b84412300c")->books()->get();
            $userParents = UserParent::findOrFail($user_parent_id)->books()->get();
            foreach($userParents as $userParent) {
                $user_child_id = $userParent->book->user_child_id;
                $array = array_collapse(UserChild::where("id", "=", $user_child_id)->get());
            }
            return $array;
//            $test = $eventDetail->books()->get();
//            return BookTestResource::collection($eventDetail);

            return EventDetail::whereHas("books", function($query) {
                $query->where("pub_state", "=", 0);
            })->get();
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
