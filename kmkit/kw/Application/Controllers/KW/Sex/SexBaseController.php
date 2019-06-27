<?php
namespace KW\Application\Controllers\Common\Sex;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\Sex;

class SexBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSexes()
    {
        return response()->json(Sex::query()->select([
            'id',
            'index',
            'name'
        ])->get());
    }

    /**
     * @param Request $request
     * @param Sex $sex
     */
    public function postSexes(Request $request, Sex $sex)
    {
        $request->validate([
            'index' => 'required',
            'name'  => 'required'
        ]);
        $sex->index = $request->json('index');
        $sex->name  = $request->json('name');
        $sex->save();
    }

    /**
     * @param $sex_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getSex($sex_id)
    {
        try {
            return Sex::where('id', $sex_id)
                ->select([
                    'id',
                    'index',
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
     * @param $sex_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putSex(Request $request, $sex_id)
    {
        try {
            $sex = Sex::where('id', $sex_id)->firstOrFail();
            $sex->index = $request->json('index');
            $sex->name  = $request->json('name');
            $sex->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $sex_id
     * @throws \Exception
     */
    public function deleteSex($sex_id)
    {
        Sex::query()->where('id', '=', $sex_id)->delete();
    }
}
