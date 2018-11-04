<?php

namespace App\Listeners\Agencies;

use App\Agencies;
use App\Events\Agencies\VacancyPaymentDetails;
use App\Mail\Agencies\PaymentDetailsEmail;
use App\User;
use Illuminate\Support\Facades\Mail;

class SendPaymentDetailsEmail
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
     * @param  VacancyPaymentDetails $event
     * @return void
     */
    public function handle(VacancyPaymentDetails $event)
    {
        Mail::to(User::find(Agencies::find($event->data['confirmAgency']->agency_id)->user_id)->email)
            ->send(new PaymentDetailsEmail($event->data));
    }
}
