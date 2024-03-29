<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'visitor' => \App\Http\Middleware\Auth\VisitorMiddleware::class,
        'seeker' => \App\Http\Middleware\Auth\SeekerMiddleware::class,
        'seeker.profile' => \App\Http\Middleware\Seekers\ProfileSeekerMiddleware::class,
        'quiz' => \App\Http\Middleware\Seekers\QuizMiddleware::class,
        'psychoTest' => \App\Http\Middleware\Seekers\PsychoTestMiddleware::class,
        'agency' => \App\Http\Middleware\Auth\AgencyMiddleware::class,
        'agency.home' => \App\Http\Middleware\Agencies\HomeAgencyMiddleware::class,
        'agency.invoice' => \App\Http\Middleware\Agencies\InvoiceAgencyMiddleware::class,
        'admin' => \App\Http\Middleware\Auth\AdminMiddleware::class,
        'admin.home' => \App\Http\Middleware\Auth\HomeAdminMiddleware::class,
        'root' => \App\Http\Middleware\Auth\Admins\RootMiddleware::class,
        'interviewer' => \App\Http\Middleware\Auth\Admins\InterviewerMiddleware::class,
        'quiz_staff' => \App\Http\Middleware\Auth\Admins\QuizStaffMiddleware::class,
        'sync_staff' => \App\Http\Middleware\Auth\Admins\SyncStaffMiddleware::class,
        'vacancy_staff' => \App\Http\Middleware\Auth\Admins\VacancyStaffMiddleware::class,
        'jwt.auth' => 'Tymon\JWTAuth\Middleware\GetUserFromToken',
        'jwt.refresh' => 'Tymon\JWTAuth\Middleware\RefreshToken',
    ];
}
