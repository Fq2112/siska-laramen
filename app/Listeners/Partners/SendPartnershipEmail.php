<?php

namespace App\Listeners\Partners;

use App\Events\Partners\UserPartnershipEmail;
use App\Mail\Partners\PartnershipEmail;
use Illuminate\Support\Facades\Mail;

class SendPartnershipEmail
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
     * @param  UserPartnershipEmail $event
     * @return void
     */
    public function handle(UserPartnershipEmail $event)
    {
        Mail::to($event->partnership->email)->send(new PartnershipEmail($event->partnership, $event->filename));
    }
}
