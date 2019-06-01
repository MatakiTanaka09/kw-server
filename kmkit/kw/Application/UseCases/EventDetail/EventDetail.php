<?php

namespace KW\Application\UseCases\EventDetail;

use KW\Domain\Models\EventDetail\BookRepositoryInterface;

class EventDetail
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

