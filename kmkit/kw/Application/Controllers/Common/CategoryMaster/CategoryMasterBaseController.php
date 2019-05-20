<?php

namespace KW\Application\Controllers\Common\CategoryMaster;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\CategoryMaster;

class CategoryMasterBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategoryMasters()
    {
        return response()->json(CategoryMaster::query()->select([
            'id',
            'name',
            'color',
            'filename'
        ])->get());
    }

    /**
     * @param Request $request
     * @param CategoryMaster $categoryMaster
     */
    public function postCategoryMasters(Request $request, CategoryMaster $categoryMaster)
    {
        $request->validate([
            'name'     => 'required',
            'color'    => 'required',
            'filename' => 'required'
        ]);
        $categoryMaster->name     = $request->json('name');
        $categoryMaster->color    = $request->json('color');
        $categoryMaster->filename = $request->json('filename');
        $categoryMaster->save();
    }

    /**
     * @param $category_master_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getCategoryMaster($category_master_id)
    {
        try {
            return CategoryMaster::where('id', $category_master_id)
                ->select([
                    'id',
                    'name',
                    'color',
                    'filename'
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
     * @param $category_master_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putCategoryMaster(Request $request, $category_master_id)
    {
        try {
            $category_master = CategoryMaster::where('id', $category_master_id)->firstOrFail();
            $category_master->name     = $request->json('name');
            $category_master->color    = $request->json('color');
            $category_master->filename = $request->json('filename');
            $category_master->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $category_master_id
     * @throws \Exception
     */
    public function deleteCategoryMaster($category_master_id)
    {
        CategoryMaster::query()->where('id', '=', $category_master_id)->delete();
    }
}
