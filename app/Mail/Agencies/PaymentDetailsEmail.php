<?php

namespace App\Mail\Agencies;

use App\Support\RomanConverter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentDetailsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $date = $data['confirmAgency']->created_at;
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
            RomanConverter::numberToRoman($date->format('m'));

        return $this->subject('Waiting for ' . $data['payment_category']->name . ' Payment #PYM/' .
            $date->format('Ymd') . '/' . $romanDate . '/' . $data['confirmAgency']->id)
            ->from(env('MAIL_USERNAME'), 'SISKA - Sistem Informasi Karier')
            ->view('emails.agencies.paymentDetails')->with($data);
    }
}
