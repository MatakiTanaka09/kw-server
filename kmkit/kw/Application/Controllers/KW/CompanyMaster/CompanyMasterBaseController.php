<?php

namespace KW\Application\Controllers\Common\CompanyMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\CompanyMaster;

class CompanyMasterBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanyMasters()
    {
        return response()->json(CompanyMaster::query()->select([
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
     * @param CompanyMaster $companyMaster
     */
    public function postCompanyMasters(Request $request, CompanyMaster $companyMaster)
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
        $companyMaster->name      = $request->json('name');
        $companyMaster->detail    = $request->json('detail');
        $companyMaster->email     = $request->json('email');
        $companyMaster->url       = $request->json('url');
        $companyMaster->tel       = $request->json('tel');
        $companyMaster->icon      = $request->json('icon');
        $companyMaster->zip_code1 = $request->json('zip_code1');
        $companyMaster->zip_code2 = $request->json('zip_code2');
        $companyMaster->state     = $request->json('state');
        $companyMaster->city      = $request->json('city');
        $companyMaster->address1  = $request->json('address1');
        $companyMaster->address2  = $request->json('address2');
        $companyMaster->longitude = $request->json('longitude');
        $companyMaster->latitude  = $request->json('latitude');
        $companyMaster->save();
    }

    /**
     * @param $company_master_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getCompanyMaster($company_master_id)
    {
        try {
            return CompanyMaster::where('id', $company_master_id)
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
     * @param $company_master_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putCompanyMaster(Request $request, $company_master_id)
    {
        try {
            $companyMaster = CompanyMaster::where('id', $company_master_id)->firstOrFail();
            $companyMaster->name      = $request->json('name');
            $companyMaster->detail    = $request->json('detail');
            $companyMaster->email     = $request->json('email');
            $companyMaster->url       = $request->json('url');
            $companyMaster->tel       = $request->json('tel');
            $companyMaster->icon      = $request->json('icon');
            $companyMaster->zip_code1 = $request->json('zip_code1');
            $companyMaster->zip_code2 = $request->json('zip_code2');
            $companyMaster->state     = $request->json('state');
            $companyMaster->city      = $request->json('city');
            $companyMaster->address1  = $request->json('address1');
            $companyMaster->address2  = $request->json('address2');
            $companyMaster->longitude = $request->json('longitude');
            $companyMaster->latitude  = $request->json('latitude');
            $companyMaster->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $company_master_id
     * @throws \Exception
     */
    public function deleteCompanyMaster($company_master_id)
    {
        CompanyMaster::query()->where('id', '=', $company_master_id)->delete();
    }
}
