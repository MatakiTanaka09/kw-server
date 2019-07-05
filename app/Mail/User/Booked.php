<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use KW\Infrastructure\Eloquents\Book;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class Booked extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Dispatchable, Queueable, SerializesModels;

    public $user;
    public $book_id;
    public $event_master;
    public $event_detail;
    public $school_master;
    public $user_children;

    /**
     * Booked constructor.
     * @param $user
     * @param $book_id
     * @param $event_master
     * @param $event_detail
     * @param $school_master
     * @param $user_children
     */
    public function __construct(
        $user,
        $book_id,
        $event_master,
        $event_detail,
        $school_master,
        $user_children
    ) {
        $this->user = $user;
        $this->book_id = $book_id;
        $this->event_master = $event_master;
        $this->event_detail = $event_detail;
        $this->school_master = $school_master;
        $this->user_children = $user_children;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->formatChildren();
        $this->formatBookId();
        return $this->view('emails.users.booked')
            ->subject("【kidsweekend】予約完了のお知らせ")
            ->with([
                "book_id"  => $this->book_id,
                "title"    => $this->event_master["title"],
                "date"     => $this->formatDate($this->event_detail["started_at"]),
                "address"  => $this->formatAddress($this->event_detail),
                "tel"      => $this->school_master["tel"],
                "children" => $this->user_children,
                "price"    => $this->event_master["price"]."円",
                "handing"  => $this->event_master["handing"]
        ]);
    }

    public function failed($event, $exception)
    {
        //
    }

    public function formatBookId()
    {
        $format_book_id = [];
        foreach ($this->book_id as $id) {
            array_push($format_book_id, "【".$id."】");
        }
        $this->book_id = implode("\n", $format_book_id);
    }

    public function formatAddress($event_detail)
    {
        return implode("", [
            $event_detail->state,
            $event_detail->city,
            $event_detail->address1,
            $event_detail->address2
        ]);
    }

    public function formatChildren()
    {
        $format_child_name = [];
        foreach ($this->user_children as $child_name) {
            array_push($format_child_name, $child_name."ちゃん");
        }

        if (count($format_child_name) == 1) {
            $this->user_children = $format_child_name[0];
        } else {
            $this->user_children = implode("、", $format_child_name);
        }
    }

    public function formatDate($date)
    {
        $dt = new Carbon($date);
        return $dt->format('Y年m月d日 H時m分');
    }
}

