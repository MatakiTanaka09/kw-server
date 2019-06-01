<?php

namespace KW\Application\Controllers\Common\UserParent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\UserParent;

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
     * @param Request $request
     * @param UserParent $userParent
     */
    public function postUserParent(Request $request, UserParent $userParent)
    {
        $request->validate([
            'user_master_id' => 'required',
            'icon'           => '',
            'sex_id'         => 'required',
            'full_name'      => 'required',
            'full_kana'      => 'required',
            'tel'            => 'required',
            'zip_code1'      => 'required',
            'zip_code2'      => 'required',
            'state'          => 'required',
            'city'           => 'required',
            'address1'       => 'required',
            'address2'       => ''
        ]);

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
     * @param Request $request
     * @param $user_parent_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putUserParent(Request $request, $user_parent_id)
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
        UserParent::query()->where('id', '=', $user_parent_id)->delete();
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

}
