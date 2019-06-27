<?php
namespace KW\Application\Controllers\User\Search\School;

use App\Http\Controllers\Controller;
use KW\Application\Resources\EventDetail\User\index\EventDetail as EventDetailResourceIndex;
use KW\Application\Resources\EventDetail\User\detail\EventDetail as EventDetailResourceDetail;
use Illuminate\Http\Request;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\EventMaster;
use Carbon\Carbon;

class SearchSchoolController extends Controller
{

    public function getEventDetailBySearchingSchool(Request $request)
    {
        $q = $request->input('q');

        return EventDetailResourceIndex::collection(
            EventDetail::whereHas("eventMaster.schoolMasters", function($query) use($q) {
                $query
                    ->where("name", "LIKE", "%" . $q . "%")
                    ->where("pub_state", "=", 0);
            })->get());
    }
}
