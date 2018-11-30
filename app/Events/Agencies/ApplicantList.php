<?php

namespace App\Events\Agencies;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ApplicantList
{
    use Dispatchable, SerializesModels;

    public $vacancy, $email, $filename;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($vacancy, $email, $filename)
    {
        $this->vacancy = $vacancy;
        $this->email = $email;
        $this->filename = $filename;
    }
}
