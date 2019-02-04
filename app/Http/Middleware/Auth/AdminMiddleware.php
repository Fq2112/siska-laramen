<?php

namespace App\Http\Middleware\Auth;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
            return $next($request);

        } else {
            if (Auth::guest()) {
                return redirect()->guest(route('home-seeker'))
                    ->with('expire', 'The page you requested requires authentication, please login to your account.');
            }
        }

        return response()->view('errors.403');
    }
}
