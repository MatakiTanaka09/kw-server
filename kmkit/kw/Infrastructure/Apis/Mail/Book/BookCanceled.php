<?php

namespace KW\Infrastructure\Apis\Mail\Book;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use KW\Infrastructure\Eloquents\UserMaster;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BookCanceled extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Dispatchable, Queueable, SerializesModels;

    protected $userMaster;

    /**
     * Registered constructor.
     * @param UserMaster $userMaster
     */
    public function __construct($userMaster)
    {
        $this->userMaster = $userMaster;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.books.book_canceled');
    }
}
