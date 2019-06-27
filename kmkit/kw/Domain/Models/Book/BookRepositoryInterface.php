<?php

namespace KW\Domain\Models\Book;

use KW\Domain\Exceptions\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

interface BookRepositoryInterface
{
    /**
     * @return JsonResponse
     */
    public function findAll(): JsonResponse;

    /**
     * @param string $bookId
     * @return JsonResponse
     * @throws ModelNotFoundException
     */
    public function findByBookId(string $bookId);

    /**
     * @param string $userParentId
     * @return Collection
     */
    public function findByUserParentId(string $userParentId);

    /**
     * @param string $eventDetailId
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function findByEventDetailId(string $eventDetailId): Collection;
}
