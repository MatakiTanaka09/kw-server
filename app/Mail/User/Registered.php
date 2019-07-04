<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use KW\Infrastructure\Eloquents\UserMaster;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Registered extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Dispatchable, Queueable, SerializesModels;

    public $userMaster;

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
        return $this->view('emails.users.registered');
    }

    public function failed($event, $exception)
    {
        //
    }
}
