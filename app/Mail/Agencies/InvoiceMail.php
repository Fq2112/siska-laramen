<?php

namespace App\Mail\Agencies;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code, $data, $instruction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $data, $instruction)
    {
        $this->code = $code;
        $this->data = $data;
        $this->instruction = $instruction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $code = $this->code;
        $instruction = $this->instruction;

        if ($data['isPaid'] == false) {
            $this->subject('Waiting for ' . $data['payment_type'] . ' Payment '.$data['invoice']);

        } else {
            $this->subject('Checkout Orders with ' . $data['payment_type'] . ' Payment Successfully Confirmed on ' .
                Carbon::parse($data['date_payment'])->format('j F Y') .
                ' at ' . Carbon::parse($data['date_payment'])->format('H:i'));
        }

        if (!is_null($this->instruction)) {
            $this->attach(env('APP_URL').'/storage/users/agencies/payment/' . $this->instruction);
        }

        return $this->from(env('MAIL_USERNAME'), env('APP_TITLE'))
            ->view('emails.agencies.invoice', compact('code', 'data', 'instruction'));
    }
}
