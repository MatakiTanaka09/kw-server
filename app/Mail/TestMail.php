<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use KW\Infrastructure\Eloquents\UserMaster;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TestMail extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Dispatchable, Queueable, SerializesModels;

    public function build()
    {
        return $this->view('emails.test');
    }
}
