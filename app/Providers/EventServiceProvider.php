<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Partners\UserPartnershipEmail' => [
            'App\Listeners\Partners\SendPartnershipEmail',
        ],
        'App\Events\Partners\ApplicantList' => [
            'App\Listeners\Partners\SendApplicantList',
        ],
        'App\Events\Auth\UserActivationEmail' => [
            'App\Listeners\Auth\SendActivationEmail',
        ],
        'App\Events\Agencies\VacancyPaymentDetails' => [
            'App\Listeners\Agencies\SendPaymentDetailsEmail',
        ],
        'App\Events\Agencies\AppliedInvitationList' => [
            'App\Listeners\Agencies\SendAppliedInvitationList',
        ],
        'App\Events\Agencies\ApplicantList' => [
            'App\Listeners\Agencies\SendApplicantList',
        ],
        'App\Events\Agencies\QuizResultList' => [
            'App\Listeners\Agencies\SendQuizResultList',
        ],
        'App\Events\Agencies\PsychoTestResultList' => [
            'App\Listeners\Agencies\SendPsychoTestResultList',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
