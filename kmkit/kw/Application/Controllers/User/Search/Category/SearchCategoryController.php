<?php
namespace KW\Application\Controllers\User\Search\Category;

use App\Http\Controllers\Controller;
use KW\Application\Resources\EventDetail\User\index\EventDetail as EventDetailResourceIndex;
use KW\Application\Resources\EventDetail\User\detail\EventDetail as EventDetailResourceDetail;
use Illuminate\Http\Request;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\EventMaster;
use Carbon\Carbon;

class SearchCategoryController extends Controller
{

    public function getEventDetailBySearchingCategory(Request $request)
    {
        $q = $request->input('q');
        $limit = $request->input('limit');
        $limit == null ? "" : $limit;

        if($this->checkQueryRegexp($q)) {
            return EventDetailResourceIndex::collection(
                EventDetail::whereHas("eventMaster.categoryMasters", function($query) use($q, $limit) {
                    $query
                        ->where("category_master_id", "=", $q)
                        ->limit($limit);
                })->get());
        } else {
            return response()
                ->json(['message' => "error"])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);;
        }
    }

    public function checkQueryRegexp($query)
    {
        $pattern = '/^0$|^-?[1-9][0-9]{0,4}$/';
        return preg_match($pattern, $query) ? true : false;
    }
}
