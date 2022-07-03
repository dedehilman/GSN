<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Config;
use App\Traits\MailServerTrait;
use Illuminate\Queue\SerializesModels;
use App\Models\MailHistory;

class AppMail extends Mailable
{
    use Queueable, SerializesModels, MailServerTrait;

    private $params;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->setMailConfig();
        if($this->params['attachment']) {
            return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($this->params['title'])
            ->view('mail.notification', ['params'=>$this->params])
            ->attach($this->params['attachment']);
        } else {
            return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($this->params['title'])
            ->view('mail.notification', ['params'=>$this->params]);
        }
    }
}
