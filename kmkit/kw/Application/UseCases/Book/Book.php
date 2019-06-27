<?php

namespace KW\Application\UseCases\Book;

use KW\Domain\Models\Book\BookRepositoryInterface;

class Book
{
    private $bookRepo;

    public function __construct(BookRepositoryInterface $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }
}

