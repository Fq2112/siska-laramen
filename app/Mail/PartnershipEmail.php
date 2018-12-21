<?php

namespace App\Mail;

use App\Partnership;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnershipEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $partnership;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Partnership $partnership)
    {
        $this->partnership = $partnership;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_USERNAME'), 'SISKA - Sistem Informasi Karier')
            ->subject('SISKA Partnership Credentials: API Key & API Secret')
            ->markdown('emails.partnership');
    }
}
