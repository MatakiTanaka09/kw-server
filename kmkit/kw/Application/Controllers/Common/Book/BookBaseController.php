<?php

namespace KW\Application\Controllers\Common\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\Book;

class BookBaseController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBooks()
    {
        return response()->json(Book::query()->select([
            'id',
            'child_parent_id',
            'event_detail_id',
            'status',
            'price'
        ])->get());
    }

    /**
     * @param Request $request
     * @param Book $book
     */
    public function postBooks(Request $request, Book $book)
    {
        $request->validate([
            'child_parent_id' => 'required',
            'event_detail_id' => 'required',
            'status'          => 'required',
            'price'           => 'required'
        ]);
        $book->child_parent_id    = $request->json('child_parent_id');
        $book->event_detail_id  = $request->json('event_detail_id');
        $book->status               = $request->json('status');
        $book->price              = $request->json('price');
        $book->save();
    }

    /**
     * @param $book_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getBook($book_id)
    {
        try {
            return Book::where('id', $book_id)
                ->select([
                    'id',
                    'child_parent_id',
                    'event_detail_id',
                    'status',
                    'price'
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
     * @param $book_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putBook(Request $request, $book_id)
    {
        try {
            $book = Book::where('id', $book_id)->firstOrFail();
            $book->child_parent_id = $request->json('child_parent_id');
            $book->event_detail_id = $request->json('event_detail_id');
            $book->status          = $request->json('status');
            $book->price           = $request->json('price');
            $book->save();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param $book_id
     * @throws \Exception
     */
    public function deleteBook($book_id)
    {
        Book::query()->where('id', '=', $book_id)->delete();
    }
}
