<?php
namespace KW\Application\Controllers\User\Search\Age;

use App\Http\Controllers\Controller;
use KW\Application\Resources\EventDetail\User\index\EventDetail as EventDetailResourceIndex;
use KW\Application\Resources\EventDetail\User\detail\EventDetail as EventDetailResourceDetail;
use Illuminate\Http\Request;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\EventMaster;
use Carbon\Carbon;

class SearchAgeController extends Controller
{

    public function getEventDetailBySearchingAge(Request $request)
    {
        $q = $request->input('q');
        $sort = $request->input('sort');
        $order = $request->input('order');

        if($this->checkEventDetailRegexp($q, $sort, $order)) {
            return EventDetailResourceIndex::collection(
                EventDetail::whereHas("eventMaster", function($query) use($q, $sort, $order) {
                    $query
                        ->where("target_min_age", "=", $q)
                        ->where("pub_state", "=", 0)
                        ->orderBy($sort, $order);
                })->get());
        } else {
            return response()
                ->json(['message' => "error"])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    public function checkEventDetailRegexp($query, $sort, $order)
    {
        if(!($this->checkQueryRegexp($query) && $this->checkSortRegexp($sort) && $this->checkOrderRegexp($order))) return false;
        return true;
    }

    public function checkQueryRegexp($query)
    {
        $pattern = '/^0$|^-?[1-9][0-9]{0,2}$/';
        return preg_match($pattern, $query) ? true : false;
    }

    public function checkSortRegexp($sort)
    {
        $sort_value = ["updated_at"];
        return in_array($sort, $sort_value, true) ? true : false;
    }

    public function checkOrderRegexp($order)
    {
        $order_value = ["desc", "asc"];
        return in_array($order, $order_value, true) ? true : false;
    }
}
