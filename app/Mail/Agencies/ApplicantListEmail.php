<?php

namespace App\Mail\Agencies;

use App\Vacancies;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicantListEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $applicants, $vacancy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($applicants, $vacancy)
    {
        $this->applicants = $applicants;
        $this->vacancy = $vacancy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $applicants = $this->applicants;
        $vacancy = $this->vacancy;
        $recruitmentDate = Carbon::parse($vacancy->recruitmentDate_start)->format('j F Y') . " - " .
            Carbon::parse($vacancy->recruitmentDate_end)->format('j F Y');

        return $this->subject("" . $vacancy->judul . ": Application List for " . $recruitmentDate)
            ->from(env('MAIL_USERNAME'), 'SISKA - Sistem Informasi Karier')
            ->view('emails.agencies.applicantList')->with($applicants);
    }
}
