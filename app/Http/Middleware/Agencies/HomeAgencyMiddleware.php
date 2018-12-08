<?php

namespace App\Http\Middleware\Agencies;

use Closure;
use Illuminate\Support\Facades\Auth;

class HomeAgencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guest() || Auth::check() && Auth::user()->isAgency() || Auth::guard('admin')->check()) {
            return $next($request);

        }
        return response(view('errors.403'), 403);
    }
}
