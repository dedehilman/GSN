<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Config;
use App\Traits\MailServerTrait;
use App\Models\MailHistory;

class AppNotification extends Notification implements ShouldQueue
{
    use Queueable, MailServerTrait;

    private $params;
    private $sendVia;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($params, $sendVia = array())
    {
        $this->params = $params;
        $this->sendVia = $sendVia;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->sendVia;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $params = $this->params;
        MailHistory::create([
            "to"=> $notifiable->email,
            "cc"=> null,
            "subject"=> $this->params['title'],
            "body"=> view('mail.notification', compact('params'))->render(),
        ]);

        $this->setMailConfig();
        return (new MailMessage)
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject($this->params['title'])
                    ->view('mail.notification', compact('params'));
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

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->params['title'],
            'content' => $this->params['content'],
            'url' => $this->params['url']
        ];
    }
}
