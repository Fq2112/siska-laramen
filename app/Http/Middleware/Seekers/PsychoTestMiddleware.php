<?php

namespace App\Http\Middleware\Seekers;

use App\PsychoTestResult;
use App\Seekers;
use Closure;
use Illuminate\Support\Facades\Auth;

class PsychoTestMiddleware
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
        if (Auth::check() && Auth::user()->isSeeker()) {
            $seeker = Seekers::where('user_id', Auth::user()->id)->first();
            $check = PsychoTestResult::where('psychoTest_id', decrypt($request->psychoTest_id))
                ->where('seeker_id', $seeker->id)->count();
            if (!$check) {
                return $next($request);
            }

        } elseif (Auth::guard('admin')->check()) {
            $check = PsychoTestResult::where('psychoTest_id', decrypt($request->psychoTest_id))
                ->where('seeker_id', $request->seeker_id)->count();
            if(!$check){
                return $next($request);
            }
        }

        return response(view('errors.403'), 403);
    }
}
