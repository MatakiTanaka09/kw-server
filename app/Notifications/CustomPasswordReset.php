<?php

namespace App\Notifications;

use App;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomPasswordReset extends Notification
{
    use Queueable;

    public $token;

    /**
     * CustomPasswordReset constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('パスワードリセット')
            ->view('emails.users.resetpass')
            ->action('リセットパスワード',
                config('frontend.url') . config('frontend.reset_pass_url') .
                url('api/v1/users/user-masters/password/reset', $this->token)
            );
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
