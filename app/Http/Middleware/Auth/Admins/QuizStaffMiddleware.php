<?php

namespace App\Http\Middleware\Auth\Admins;

use Closure;
use Illuminate\Support\Facades\Auth;

class QuizStaffMiddleware
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
            if (Auth::guard('admin')->user()->isRoot() || Auth::guard('admin')->user()->isQuizStaff()) {
                return $next($request);
            }

        } else {
            return $next($request);
        }

        return response()->view('errors.403');
    }
}
