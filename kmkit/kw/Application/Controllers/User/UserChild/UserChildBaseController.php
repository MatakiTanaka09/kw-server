<?php
namespace KW\Application\Controllers\User\UserChild;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use KW\Application\Requests\UserParent\User\UserAccount as UserAccountRequest;
use KW\Application\Requests\UserChild\User\UserChild as UserChildRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\UserChild;
use Carbon\Carbon;

class UserChildBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserChildren()
    {
        return response()->json(UserChild::query()->select([
            'id',
            'sex_id',
            'icon',
            'full_name',
            'full_kana',
            'birth_day'
        ])->get());
    }

    /**
     * @param UserAccountRequest $request
     * @param UserChild $userChild
     * @param $user_parent_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postUserChildren(UserAccountRequest $request, $user_parent_id)
    {
        $result = [];
        $data = $request->json("children");
        if(is_array($data)) {
            for($i=0; $i < count($data); $i++) {
                $userChild = new UserChild();
                $userChild->sex_id      = $data[$i]["sex_id"];
                $userChild->icon        = $data[$i]["icon"];
                $userChild->full_name   = $data[$i]["full_name"];
                $userChild->full_kana   = $data[$i]["full_kana"];
                $userChild->birth_day   = $data[$i]["birth_day"];
                $userChild->save();
                array_push($result, $userChild);
                $this->attachUserChildToUserParent($user_parent_id, $userChild);
            }
        }
        return UserChildBaseController::receiveResponse($result);
    }

    /**
     * @param Request $request
     * @param $user_parent_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdditionalUserChildren(Request $request, $user_parent_id)
    {
        $result = [];
        $data = $request->json("children");
        if(is_array($data)) {
            for($i=0; $i < count($data); $i++) {
                $userChild = new UserChild();
                $userChild->sex_id      = $data[$i]["sex_id"];
                $userChild->icon        = $data[$i]["icon"];
                $userChild->full_name   = $data[$i]["full_name"];
                $userChild->full_kana   = $data[$i]["full_kana"];
                $userChild->birth_day   = $data[$i]["birth_day"];
                $userChild->save();
                array_push($result, $userChild);
                $this->attachUserChildToUserParent($user_parent_id, $userChild);
            }
        }
        return UserChildBaseController::receiveResponse($result);
    }

    /**
     * @param $user_child_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getUserChild($user_child_id)
    {
        try {
            return UserChild::where('id', $user_child_id)
                ->select([
                    'id',
                    'sex_id',
                    'icon',
                    'full_name',
                    'full_kana',
                    'birth_day'
                ])
                ->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            return UserChildBaseController::errorMessage($exception);
        }
    }

    /**
     * @param UserChildRequest $request
     * @param $user_child_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putUserChild(UserChildRequest $request, $user_child_id)
    {
        try {
            $userChild = UserChild::where('id', $user_child_id)->firstOrFail();
            $userChild->sex_id     = $request->json('sex_id');
            $userChild->icon       = $request->json('icon');
            $userChild->full_name = $request->json('full_name');
            $userChild->full_kana  = $request->json('full_kana');
            $userChild->birth_day  = $request->json('birth_day');
            $userChild->save();
            return UserChildBaseController::receiveResponse($userChild);
        } catch (ModelNotFoundException $exception) {
            return UserChildBaseController::errorMessage($exception);
        }
    }

    /**
     * @param $user_child_id
     * @throws \Exception
     */
    public function deleteUserChild($user_child_id)
    {
        $userChild = UserChild::query()->where('id', '=', $user_child_id)->firstOrFail();
        $userChild->userParents()->detach();
        $userChild->delete();
    }


    public function attachUserChildToUserParent($user_parent_id, $userChild)
    {
        $userChild->userParents()->attach($user_parent_id, [
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
