<?php

namespace KW\Application\Controllers\Common\SchoolMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\SchoolMaster;

class SchoolMasterBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchoolMasters()
    {
        return response()->json(SchoolMaster::query()->select([
            'id',
            'name',
            'detail',
            'email',
            'url',
            'tel',
            'icon',
            'zip_code1',
            'zip_code2',
            'state',
            'city',
            'address1',
            'address2',
            'longitude',
            'latitude'
        ])->get());
    }

    /**
     * @param Request $request
     * @param SchoolMaster $schoolMaster
     */
    public function postSchoolMasters(Request $request, SchoolMaster $schoolMaster)
    {
        $request->validate([
            'name'      => 'required',
            'detail'    => 'required',
            'email'     => 'required',
            'url'       => 'required',
            'tel'       => 'required',
            'icon'      => 'required',
            'zip_code1' => 'required',
            'zip_code2' => 'required',
            'state'     => 'required',
            'city'      => 'required',
            'address1'  => 'required',
            'address2'  => 'required',
            'longitude' => 'required',
            'latitude'  => 'required',
        ]);
        $schoolMaster->name      = $request->json('name');
        $schoolMaster->detail    = $request->json('detail');
        $schoolMaster->email     = $request->json('email');
        $schoolMaster->url       = $request->json('url');
        $schoolMaster->tel       = $request->json('tel');
        $schoolMaster->icon      = $request->json('icon');
        $schoolMaster->zip_code1 = $request->json('zip_code1');
        $schoolMaster->zip_code2 = $request->json('zip_code2');
        $schoolMaster->state     = $request->json('state');
        $schoolMaster->city      = $request->json('city');
        $schoolMaster->address1  = $request->json('address1');
        $schoolMaster->address2  = $request->json('address2');
        $schoolMaster->longitude = $request->json('longitude');
        $schoolMaster->latitude  = $request->json('latitude');
        $schoolMaster->save();
    }

    /**
     * @param $school_master_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getSchoolMaster($school_master_id)
    {
        try {
            return SchoolMaster::where('id', $school_master_id)
                ->select([
                    'id',
                    'name',
                    'detail',
                    'email',
                    'url',
                    'tel',
                    'icon',
                    'zip_code1',
                    'zip_code2',
                    'state',
                    'city',
                    'address1',
                    'address2',
                    'longitude',
                    'latitude'
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
     * @param $school_master_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putSchoolMaster(Request $request, $school_master_id)
    {
        try {
            $schoolMaster = SchoolMaster::where('id', $school_master_id)->firstOrFail();
            $schoolMaster->name      = $request->json('name');
            $schoolMaster->detail    = $request->json('detail');
            $schoolMaster->email     = $request->json('email');
            $schoolMaster->url       = $request->json('url');
            $schoolMaster->tel       = $request->json('tel');
            $schoolMaster->icon      = $request->json('icon');
            $schoolMaster->zip_code1 = $request->json('zip_code1');
            $schoolMaster->zip_code2 = $request->json('zip_code2');
            $schoolMaster->state     = $request->json('state');
            $schoolMaster->city      = $request->json('city');
            $schoolMaster->address1  = $request->json('address1');
            $schoolMaster->address2  = $request->json('address2');
            $schoolMaster->longitude = $request->json('longitude');
            $schoolMaster->latitude  = $request->json('latitude');
            $schoolMaster->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $school_master_id
     * @throws \Exception
     */
    public function deleteSchoolMaster($school_master_id)
    {
        SchoolMaster::query()->where('id', '=', $school_master_id)->delete();
    }
}
