<?php

namespace App\Events\Agencies;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ApplicantList
{
    use Dispatchable, SerializesModels;

    public $applicants, $vacancy, $email;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($applicants, $vacancy, $email)
    {
        $this->applicants = $applicants;
        $this->vacancy = $vacancy;
        $this->email = $email;
    }
}
