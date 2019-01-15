<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Support\Facades\Auth;

class HomeAdminMiddleware
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
        if (Auth::guard('admin')->check()) {
            if (!Auth::guard('admin')->user()->isInterviewer()) {
                return $next($request);
            }

        } else {
            if (Auth::guest()) {
                return redirect()->guest(route('home-seeker'))
                    ->with('expire', 'The page you requested requires authentication, please login to your account.');
            }
        }

        return response(view('errors.403'), 403);
    }
}
