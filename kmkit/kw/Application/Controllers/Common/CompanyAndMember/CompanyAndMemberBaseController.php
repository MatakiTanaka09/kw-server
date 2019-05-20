<?php

namespace KW\Application\Controllers\Common\CompanyAndMember;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\CompanyAndMember;

class CompanyAndMemberBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCompanyAndMembers()
    {
        return response()->json(CompanyAndMember::query()->select([
            'id',
            'company_master_id',
            'company_admin_master_id',
            'name'
        ])->get());
    }

    /**
     * @param Request $request
     * @param CompanyAndMember $companyAndMember
     */
    public function postCompanyAndMembers(Request $request, CompanyAndMember $companyAndMember)
    {
        $request->validate([
            'company_master_id'       => 'required',
            'company_admin_master_id' => 'required',
            'name'                    => 'required'
        ]);
        $companyAndMember->company_master_id       = $request->json('company_master_id');
        $companyAndMember->company_admin_master_id = $request->json('company_admin_master_id');
        $companyAndMember->name                    = $request->json('name');
        $companyAndMember->save();
    }

    /**
     * @param $company_and_member_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getCompanyAndMember($company_and_member_id)
    {
        try {
            return CompanyAndMember::where('id', $company_and_member_id)
                ->select([
                    'id',
                    'company_master_id',
                    'company_admin_master_id',
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
     * @param $company_and_member_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putCompanyAndMember(Request $request, $company_and_member_id)
    {
        try {
            $company_and_member = CompanyAndMember::where('id', $company_and_member_id)->firstOrFail();
            $company_and_member->company_master_id       = $request->json('company_master_id');
            $company_and_member->company_admin_master_id = $request->json('company_admin_master_id');
            $company_and_member->name                    = $request->json('name');
            $company_and_member->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $company_and_member_id
     * @throws \Exception
     */
    public function deleteCompanyAndMember($company_and_member_id)
    {
        CompanyAndMember::query()->where('id', '=', $company_and_member_id)->delete();
    }
}
