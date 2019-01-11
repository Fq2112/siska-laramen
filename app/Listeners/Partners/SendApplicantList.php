<?php

namespace App\Listeners\Partners;

use App\Events\Partners\ApplicantList;
use App\Mail\Partners\ApplicantListEmail;
use Illuminate\Support\Facades\Mail;

class SendApplicantList
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ApplicantList $event
     * @return void
     */
    public function handle(ApplicantList $event)
    {
        Mail::to($event->email)->send(new ApplicantListEmail($event->vacancy, $event->filename));
    }
}
