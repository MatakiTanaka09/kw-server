<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use KW\Infrastructure\Eloquents\Book;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Booked extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Dispatchable, Queueable, SerializesModels;

    public $user;
    public $event_detail;
    public $user_children;

    /**
     * Booked constructor.
     * @param $user
     * @param $event_detail
     * @param $user_children
     */
    public function __construct($user, $event_detail)
    {
        $this->user = $user;
        $this->event_detail = $event_detail;
//        $this->user_children = $user_children;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        $this->user_children = implode(",", $this->user_children);
        return $this->view('emails.users.booked');
    }

    public function failed($event, $exception)
    {
        //
    }
}
