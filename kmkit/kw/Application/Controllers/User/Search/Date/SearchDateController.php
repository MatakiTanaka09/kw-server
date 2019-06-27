<?php
namespace KW\Application\Controllers\User\Search\Date;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Application\Resources\EventDetail\User\index\EventDetail as EventDetailResourceIndex;
use KW\Application\Resources\EventDetail\User\detail\EventDetail as EventDetailResourceDetail;
use Illuminate\Http\Request;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\EventMaster;
use Carbon\Carbon;

class SearchDateController extends Controller
{

    public function getEventDetailBySearchingDate(Request $request)
    {
        $q = $request->input('q');
        $sort = $request->input('sort');
        $order = $request->input('order');
        $limit = $request->input('limit');
        $limit == null ? "" : $limit;

        if($this->checkEventDetailRegexp($q, $sort, $order)) {
            try {
                return EventDetailResourceIndex::collection(
                    EventDetail::query()
                        ->where("pub_state", "=", 0)
                        ->whereDate("updated_at", ">=", $q)
                        ->orderBy($sort, $order)
                        ->limit($limit)
                        ->get()
                );
            } catch(ModelNotFoundException $exception) {
                return SearchDateController::errorMessage($exception);
            }
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
        $pattern = '/^([1-9][0-9]{3})-(0[1-9]{1}|1[0-2]{1})-(0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})$/';
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

    private static function receiveResponse($result)
    {
        return response()->json([
            'result' => 'ok',
            'data' => $result
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
