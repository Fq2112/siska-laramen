<?php

namespace App\Listeners\Agencies;

use App\Events\Agencies\QuizResultList;
use App\Mail\Agencies\QuizResultListEmail;
use Illuminate\Support\Facades\Mail;

class SendQuizResultList
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
     * @param  QuizResultList $event
     * @return void
     */
    public function handle(QuizResultList $event)
    {
        Mail::to($event->email)->send(new QuizResultListEmail($event->vacancy, $event->filename));
    }
}
