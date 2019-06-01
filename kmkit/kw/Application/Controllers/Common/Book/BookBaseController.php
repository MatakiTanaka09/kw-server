<?php

namespace KW\Application\Controllers\Common\Book;

use App\Http\Controllers\Controller;
use KW\Application\Requests\Book\EventDetail as BookRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\Book;
use KW\Domain\Models\Book\BookRepositoryInterface;
use Illuminate\Support\Collection;

class BookBaseController extends Controller
{
    /**
     * @var BookRepositoryInterface
     */
    private $bookRepo;

    public function __construct(BookRepositoryInterface $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }

    /**
     * @return JsonResponse
     */
    public function getBooks(): JsonResponse
    {
        $books = $this->bookRepo->findAll();
        return $books;
    }

    /**
     * @param BookRequest $request
     * @param Book $book
     */
    public function postBooks(BookRequest $request, Book $book)
    {
        $book->user_parent_id  = $request->json('user_parent_id');
        $book->event_detail_id = $request->json('event_detail_id');
        $book->status          = $request->json('status');
        $book->price           = $request->json('price');
        $book->save();
    }

    /**
     * @param $book_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function getBook($book_id)
    {
        $book = $this->bookRepo->findByBookId($book_id);
        return $book;
    }

    /**
     * @param BookRequest $request
     * @param $book_id
     * @return JsonResponse
     */
    public function putBook(BookRequest $request, $book_id)
    {
        try {
            $book = Book::where('id', $book_id)->firstOrFail();
            $book->user_parent_id  = $request->json('user_parent_id');
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
