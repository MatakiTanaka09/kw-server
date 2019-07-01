<?php

namespace KW\Application\Controllers\KW\SchoolMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use KW\Application\Requests\SchoolMaster\KW\SchoolMaster as SchoolMasterRequest;
use KW\Application\Requests\SchoolMaster\KW\Upload as UploadRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\SchoolMaster;

class SchoolMasterBaseController extends Controller
{
    /**
     * @var EventDetailRepositoryInterface
     */
    private $upload;

    /**
     * SchoolMasterBaseController constructor.
     * @param UploadController $upload
     */
    public function __construct(UploadController $upload)
    {
        $this->upload = $upload;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchoolMasters()
    {
        return SchoolMaster::paginate(15);
//        return response()->json(SchoolMaster::query()->select([
//            'id',
//            'name',
//            'detail',
//            'email',
//            'url',
//            'tel',
//            'icon',
//            'zip_code1',
//            'zip_code2',
//            'state',
//            'city',
//            'address1',
//            'address2',
//            'longitude',
//            'latitude'
//        ])->get());
    }

    /**
     * @param SchoolMasterRequest $request
     * @param SchoolMaster $schoolMaster
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSchoolMasters(SchoolMasterRequest $request, SchoolMaster $schoolMaster)
    {
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

        return SchoolMasterBaseController::receiveResponse($schoolMaster);
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
            return SchoolMasterBaseController::errorMessage($exception);
        }
    }

    /**
     * @param SchoolMasterRequest $request
     * @param $school_master_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putSchoolMaster(SchoolMasterRequest $request, $school_master_id)
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

            return SchoolMasterBaseController::receiveResponse($schoolMaster);
        } catch (ModelNotFoundException $exception) {
            return SchoolMasterBaseController::errorMessage($exception);
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

    public function attachSchoolMasterToImage(UploadRequest $request, $event_master_id)
    {
        $eventMaster = EventMaster::where('id', $event_master_id)->firstOrFail();
        $url = $this->upload->postEventDetailImage($request);
        foreach ($url as $u) {
            $eventMaster->images()->create([
                "url" => $u,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
        return SchoolMasterBaseController::receiveResponse($url);
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
