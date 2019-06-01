<?php

namespace KW\Infrastructure\Repositories\Domain\Eloquent\Book;

use KW\Domain\Exceptions\ModelNotFoundExeption;
use KW\Domain\Models\Book\BookRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use KW\Infrastructure\Eloquents\Book;
use KW\Infrastructure\Eloquents\UserParent;
use KW\Infrastructure\Eloquents\EventDetail;

final class EloquentBookRepository implements BookRepositoryInterface
{
    /** @var Book */
    private $eloquent;

    /**
     * EloquentBookRepository constructor.
     * @param Book $eloquent
     */
    public function __construct(Book $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    /**
     * @return JsonResponse
     */
    public function findAll(): JsonResponse
    {
        return response()->json($this->eloquent::query()->select([
            'id',
            'user_parent_id',
            'event_detail_id',
            'status',
            'price'
        ])->get());
    }

    /**
     * @param string $bookId
     * @return JsonResponse
     */
    public function findByBookId(string $bookId)
    {
        try {
            return $this->eloquent::where('id', $bookId)
                ->select([
                    'id',
                    'user_parent_id',
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
     * @param string $userParentId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|JsonResponse|Collection|UserParent[]
     */
    public function findByUserParentId(string $userParentId)
    {
        try {
            return UserParent::query()->where('id', '=', $userParentId)->get();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }

    /**
     * @param string $eventDetailId
     * @return Collection
     * @throws NotFoundException
     */
    public function findByEventDetailId(string $eventDetailId): Collection
    {
        try {
            return EventDetail::query()->where('id', '=', $eventDetailId)->get();
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json(['message' => $exception->getMessage()])
                ->header('Content-Type', 'application/json')
                ->setStatusCode(404);
        }
    }
}
