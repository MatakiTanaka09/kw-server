<?php

namespace KW\Infrastructure\Apis\Notifications\Book;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookCanceled extends Notification implements ShouldQueue
{
    use Queueable, Notifiable;

    public $book;
    private $viewUrl = 'emails.books.book_canceled';

    /**
     * BookCanceled constructor.
     * @param $book
     */
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('【Kidsweekend】予約をキャンセルしました')
            ->view($this->viewUrl)
            ->with([
                'id' =>$this->book->id,
                'child_parent_id' => $this->book->child_parent_id,
                'event_detail_id' => $this->book->event_detail_id,
                'status' => $this->book->status,
                'price' => $this->book->price
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
