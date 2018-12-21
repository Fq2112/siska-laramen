<?php

namespace App\Mail;

use App\Partnership;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnershipEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $partnership, $filename;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Partnership $partnership, $filename)
    {
        $this->partnership = $partnership;
        $this->filename = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $filename = $this->filename;
        return $this->from(env('MAIL_USERNAME'), 'SISKA - Sistem Informasi Karier')
            ->subject('SISKA Partnership Credentials: API Key & API Secret')
            ->view('emails.partnership')
            ->attach(public_path('storage\users\partners') . '/' . $filename);
    }
}
