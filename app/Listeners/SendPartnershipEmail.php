<?php

namespace App\Listeners;

use App\Events\UserPartnershipEmail;
use App\Mail\PartnershipEmail;
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
