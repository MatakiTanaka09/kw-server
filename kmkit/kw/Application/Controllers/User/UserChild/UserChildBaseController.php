<?php
namespace KW\Application\Controllers\User\UserChild;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            'first_kana',
            'last_kana',
            'birth_day'
        ])->get());
    }

    /**
     * @param UserChildRequest $request
     * @param UserChild $userChild
     */
    public function postUserChildren(UserChildRequest $request, UserChild $userChild)
    {
        $userChild->sex_id      = $request->json('sex_id');
        $userChild->icon        = $request->json('icon');
        $userChild->first_kana  = $request->json('first_kana');
        $userChild->last_kana   = $request->json('last_kana');
        $userChild->birth_day   = $request->json('birth_day');
        $userChild->save();

        $user_parent_id = $request->json('user_parent_id');
        $this->attachUserChildToUserParent($user_parent_id, $userChild);
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
                    'first_kana',
                    'last_kana',
                    'birth_day'
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
            $userChild->first_kana = $request->json('first_kana');
            $userChild->last_kana  = $request->json('last_kana');
            $userChild->birth_day  = $request->json('birth_day');
            $userChild->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
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
}
