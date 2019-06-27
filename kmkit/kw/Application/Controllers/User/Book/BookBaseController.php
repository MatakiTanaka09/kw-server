<?php

namespace KW\Application\Controllers\User\Book;

use App\Http\Controllers\Controller;
use KW\Application\Requests\Book\User\Book as BookRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\Book;

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
        $data = $request->json()->all();
        if(is_array($data)) {
            for($i=0; $i < count($data); $i++) {
                $book = new Book();
                $book->user_parent_id  = $data[$i]['user_parent_id'];
                $book->user_child_id   = $data[$i]['user_child_id'];
                $book->event_detail_id = $data[$i]['event_detail_id'];
                $book->status          = $data[$i]['status'];
                $book->price           = $data[$i]['price'];
                $book->save();
                array_push($result, $book);
            }
        }
        return BookBaseController::receiveResponse($result);
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
