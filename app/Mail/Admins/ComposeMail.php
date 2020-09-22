<?php

namespace App\Mail\Admins;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComposeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject, $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->message;

        return $this->from(env('MAIL_USERNAME'), env('APP_TITLE'))->subject($this->subject)
            ->view('emails.admins.admin-mail', compact('data'));
    }
}
