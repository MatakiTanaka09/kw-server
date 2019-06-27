<?php

namespace KW\Application\Controllers\Common\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\Role;

class RoleBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoles()
    {
        return response()->json(Role::query()->select([
            'id',
            'name',
            'role'
        ])->get());
    }

    /**
     * @param Request $request
     * @param Role $role
     */
    public function postRoles(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required'
        ]);
        $role->name = $request->json('name');
        $role->role = $request->json('role');
        $role->save();
    }

    /**
     * @param $role_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getRole($role_id)
    {
        try {
            return Role::where('id', $role_id)
                ->select([
                    'id',
                    'name',
                    'role'
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
     * @param $role_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putRole(Request $request, $role_id)
    {
        try {
            $role = Role::where('id', $role_id)->firstOrFail();
            $role->name = $request->json('name');
            $role->role = $request->json('role');
            $role->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $role_id
     * @throws \Exception
     */
    public function deleteRole($role_id)
    {
        Role::query()->where('id', '=', $role_id)->delete();
    }
}
