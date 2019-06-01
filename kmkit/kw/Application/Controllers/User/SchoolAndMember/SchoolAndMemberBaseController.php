<?php

namespace KW\Application\Controllers\Common\SchoolAndMember;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\SchoolAndMember;

class SchoolAndMemberBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchoolAndMembers()
    {
        return response()->json(SchoolAndMember::query()->select([
            'id',
            'school_master_id',
            'school_admin_master_id',
            'name'
        ])->get());
    }

    /**
     * @param Request $request
     * @param SchoolAndMember $schoolAndMember
     */
    public function postSchoolAndMembers(Request $request, SchoolAndMember $schoolAndMember)
    {
        $request->validate([
            'school_master_id'       => 'required',
            'school_admin_master_id' => 'required',
            'name'                    => 'required'
        ]);
        $schoolAndMember->school_master_id       = $request->json('school_master_id');
        $schoolAndMember->school_admin_master_id = $request->json('school_admin_master_id');
        $schoolAndMember->name                   = $request->json('name');
        $schoolAndMember->save();
    }

    /**
     * @param $school_and_member_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getSchoolAndMember($school_and_member_id)
    {
        try {
            return SchoolAndMember::where('id', $school_and_member_id)
                ->select([
                    'id',
                    'school_master_id',
                    'school_admin_master_id',
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
     * @param $school_and_member_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putSchoolAndMember(Request $request, $school_and_member_id)
    {
        try {
            $school_and_member = SchoolAndMember::where('id', $school_and_member_id)->firstOrFail();
            $school_and_member->school_master_id       = $request->json('school_master_id');
            $school_and_member->school_admin_master_id = $request->json('school_admin_master_id');
            $school_and_member->name                    = $request->json('name');
            $school_and_member->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $school_and_member_id
     * @throws \Exception
     */
    public function deleteSchoolAndMember($school_and_member_id)
    {
        SchoolAndMember::query()->where('id', '=', $school_and_member_id)->delete();
    }
}
