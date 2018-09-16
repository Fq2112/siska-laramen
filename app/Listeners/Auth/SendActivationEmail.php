<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserActivationEmail;
use App\Mail\Auth\ActivationEmail;
use Illuminate\Support\Facades\Mail;

class SendActivationEmail
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
     * @param  UserActivationEmail $event
     * @return void
     */
    public function handle(UserActivationEmail $event)
    {
        if ($event->user->status) {
            return;
        }
        Mail::to($event->user->email)->send(new ActivationEmail($event->user));
    }
}
