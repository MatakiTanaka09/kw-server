<?php
declare(strict_types=1);

namespace KW\Domain\Event\Book;

final class Book
{
    private $id;
    private $child_parent_id;
    private $event_detail_id;
    private $status;
    private $price;

    public function __construct(
        string $id,
        string $child_parent_id,
        string $event_detail_id,
        int $status,
        $price
    ) {
        $this->id = $id;
        $this->child_parent_id = $child_parent_id;
        $this->event_detail_id = $event_detail_id;
        $this->status = $status;
        $this->price = $price;
    }

    public function getStatus() :int
    {
        return $this->status;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getId() :string
    {
        return $this->id;
    }

    public function getChildParentId() :string
    {
        return $this->child_parent_id;
    }

    public function getEventSchoolId() :string
    {
        return $this->event_detail_id;
    }
}
