<?php

namespace KW\Application\Controllers\KW\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\Book;
use KW\Domain\Models\Book\BookRepositoryInterface;
use KW\Application\Resources\Book\KW\detail\Book as BookResource;
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
     * @param Request $request
     * @param Book $book
     */
    public function postBooks(Request $request, Book $book)
    {
        $book->user_parent_id  = $request->json('user_parent_id');
        $book->user_child_id   = $request->json('user_child_id');
        $book->event_detail_id = $request->json('event_detail_id');
        $book->status          = $request->json('status');
        $book->price           = $request->json('price');
        $book->save();
    }

    /**
     * @param $book_id
     * @return JsonResponse
     */
    public function getBook($book_id)
    {
        $book = $this->bookRepo->findByBookId($book_id);
        return $book;
    }

    /**
     * @param Request $request
     * @param $book_id
     * @return JsonResponse
     */
    public function putBook(Request $request, $book_id)
    {
        try {
            $book = Book::where('id', $book_id)->firstOrFail();
            $book->user_parent_id  = $request->json('user_parent_id');
            $book->user_child_id   = $request->json('user_child_id');
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

    /**
     * @param $user_parent_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getBookByUserParentId($user_parent_id)
    {
        $user_parent = $this->bookRepo->findByUserParentId($user_parent_id);
        $eventDetail = $user_parent->books()->get();
        return BookResource::collection($eventDetail);
    }

    /**
     * @param $event_detail_id
     * @return Collection
     */
    public function getBookByEventDetailId($event_detail_id)
    {
        $books = $this->bookRepo->findByEventDetailId($event_detail_id);
        return BookResource::collection($books);
    }
}
