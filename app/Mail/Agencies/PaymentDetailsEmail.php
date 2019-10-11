<?php

namespace App\Mail\Agencies;

use App\Support\RomanConverter;
use Carbon\Carbon;
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

        if ($data['confirmAgency']->isPaid == false) {
            if ($data['confirmAgency']->isAbort == false) {
                return $this->subject('Waiting for ' . $data['payment_category']->name . ' Payment #PYM/' .
                    $date->format('Ymd') . '/' . $romanDate . '/' . $data['confirmAgency']->id)
                    ->from(env('MAIL_USERNAME'), 'SISKA - Sistem Informasi Karier')
                    ->view('emails.agencies.paymentDetails')->with($data);

            } else {
                return $this->subject('Your ' . $data['payment_category']->name . ' Payment on ' .
                    Carbon::parse($date)->format('l, j F Y') . ' has been Aborted')
                    ->from(env('MAIL_USERNAME'), 'SISKA - Sistem Informasi Karier')
                    ->view('emails.agencies.paymentAbortedDetails')->with($data);
            }

        } else {
            return $this->subject('Checkout Orders with ' . $data['payment_category']->name .
                ' Payment Successfully Confirmed on ' . Carbon::parse($data['confirmAgency']->date_payment)->format('j F Y')
                . ' at ' . Carbon::parse($data['confirmAgency']->date_payment)->format('H:i'))
                ->from(env('MAIL_USERNAME'), 'SISKA - Sistem Informasi Karier')
                ->view('emails.agencies.paymentSuccessDetails')->with($data);
        }
    }
}
