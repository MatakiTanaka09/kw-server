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
     * @param BookRequest $request
     * @param Book $book
     * @return JsonResponse
     */
    public function postBooks(BookRequest $request, Book $book)
    {
        $book->user_parent_id  = $request->json('user_parent_id');
        $book->event_detail_id = $request->json('event_detail_id');
        $book->status          = $request->json('status');
        $book->price           = $request->json('price');
        $book->save();

        return BookBaseController::receiveResponse($book);
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
