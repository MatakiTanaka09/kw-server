<?php

namespace KW\Application\Controllers\User\Book;

use App\Http\Controllers\Controller;
use KW\Application\Requests\Book\EventDetail as BookRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use KW\Infrastructure\Eloquents\Book;
use KW\Domain\Models\Book\BookRepositoryInterface;
use KW\Application\Resources\Book\User\index\UserParent as UserBookIndexResource;
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
     * @param $user_parent_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getBooks($user_parent_id)
    {
        $user_parent = $this->bookRepo->findByUserParentId($user_parent_id);
        return UserBookIndexResource::collection($user_parent);
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
}
