<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if($guard == 'web'){
                if (Auth::user()->isSeeker()) {
                    return redirect()->route('home-seeker');

                } elseif (Auth::user()->isAgency()) {
                    return redirect()->route('home-agency');
                }

            } elseif ($guard == 'admin') {
                if (Auth::guard('admin')->user()->isInterviewer()) {
                    return redirect()->route('dashboard.interviewer');

                } else {
                    return redirect()->route('home-admin');
                }
            }
        }

        return $next($request);
    }
}
