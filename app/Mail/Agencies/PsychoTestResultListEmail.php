<?php

namespace App\Mail\Agencies;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PsychoTestResultListEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $vacancy, $filename;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vacancy, $filename)
    {
        $this->vacancy = $vacancy;
        $this->filename = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $vacancy = $this->vacancy;
        $filename = $this->filename;
        $psychoTestDate = Carbon::parse($vacancy->psychoTestDate_start)->format('j F Y') . " - " .
            Carbon::parse($vacancy->psychoTestDate_end)->format('j F Y');

        return $this->subject("" . $vacancy->judul . ": Psycho Test Result List for " . $psychoTestDate)
            ->from(env('MAIL_USERNAME'), 'SISKA - Sistem Informasi Karier')
            ->view('emails.agencies.psychoTestResultList')->with(["vacancy" => $vacancy])
            ->attach(env('APP_URL') . '/local/storage/app/public/users/agencies/reports/psychoTestResults/' . $filename);
    }
}
