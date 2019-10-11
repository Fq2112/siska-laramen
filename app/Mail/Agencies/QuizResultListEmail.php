<?php

namespace App\Mail\Agencies;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizResultListEmail extends Mailable
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
        $quizDate = Carbon::parse($vacancy->quizDate_start)->format('j F Y') . " - " .
            Carbon::parse($vacancy->quizDate_end)->format('j F Y');

        return $this->subject("" . $vacancy->judul . ": Quiz Result List for " . $quizDate)
            ->from(env('MAIL_USERNAME'), 'SISKA - Sistem Informasi Karier')
            ->view('emails.agencies.quizResultList')->with(["vacancy" => $vacancy])
            ->attach(env('APP_URL') . '/local/storage/app/public/users/agencies/reports/quizResults/' . $filename);
    }
}
