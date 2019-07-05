<?php

namespace KW\Application\Controllers\User\Book;

use App\Http\Controllers\Controller;
use KW\Application\Requests\Book\User\Book as BookRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\Book;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Application\Resources\Book\User\Mail\booked\EventDetail as EventDetailResource;
use KW\Infrastructure\Eloquents\UserChild;
use KW\Infrastructure\Eloquents\EventMaster;
use KW\Infrastructure\Eloquents\SchoolMaster;

class BookBaseController extends Controller
{
    /**
     * @param Request $request
     * @param $book_id
     * @return JsonResponse
     */
    public function putBook(Request $request, $book_id)
    {
        $request->validate([
            'status' => 'required|integer',
        ]);
        try {
            $book = Book::where('id', $book_id)->firstOrFail();
            $book->status = $request->json('status');
            $book->save();
            return BookBaseController::receiveResponse($book);
        } catch (ModelNotFoundException $exception) {
            return BookBaseController::errorMessage($exception);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postBooks(Request $request)
    {
        $result = [];
        $user_children = [];
        $event_detail = [];
        $school_master = [];
        $book_id = [];
        $user = $request->user();
        $data = $request->json()->all();

        if(is_array($data)) {
            for($i=0; $i < count($data); $i++) {
                $book = new Book();
                $book->user_parent_id   = $data[$i]['user_parent_id'];
                $book->user_child_id    = $data[$i]['user_child_id'];
                $book->event_detail_id  = $data[$i]['event_detail_id'];
                $book->school_master_id = $data[$i]['school_master_id'];
                $book->status           = $data[$i]['status'];
                $book->price            = $data[$i]['price'];
                $book->remark           = $data[$i]['remark'];
                $book->save();
                array_push($result, $book);
            }
        }

        foreach ($result as $res) {
            $user_child = UserChild::find($res->user_child_id);
            array_push($book_id, $res->id);
            array_push($user_children, $user_child->full_kana);
            array_push($event_detail, $res->event_detail_id);
            array_push($school_master, $res->school_master_id);
        }

        $event_detail = EventDetail::find($event_detail[0]);
        $event_master = $event_detail->eventMaster()->get()[0];
        $school_master = SchoolMaster::find($school_master[0]);
        \Mail::to($user)->queue(new \App\Mail\User\Booked($user, $book_id, $event_master, $event_detail, $school_master, $user_children));
//        return BookBaseController::receiveResponse($result);
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
