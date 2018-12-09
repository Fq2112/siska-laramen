<?php

namespace App\Listeners\Agencies;

use App\Events\Agencies\PsychoTestResultList;
use App\Mail\Agencies\PsychoTestResultListEmail;
use Illuminate\Support\Facades\Mail;

class SendPsychoTestResultList
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
     * @param  PsychoTestResultList $event
     * @return void
     */
    public function handle(PsychoTestResultList $event)
    {
        Mail::to($event->email)->send(new PsychoTestResultListEmail($event->vacancy, $event->filename));
    }
}
