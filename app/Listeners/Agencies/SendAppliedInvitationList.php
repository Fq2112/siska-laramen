<?php

namespace App\Listeners\Agencies;

use App\Events\Agencies\AppliedInvitationList;
use App\Mail\Agencies\AppliedInvitationListEmail;
use Illuminate\Support\Facades\Mail;

class SendAppliedInvitationList
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
     * @param  AppliedInvitationList $event
     * @return void
     */
    public function handle(AppliedInvitationList $event)
    {
        Mail::to($event->email)->send(new AppliedInvitationListEmail($event->vacancy, $event->filename));
    }
}
