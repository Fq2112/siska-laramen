<?php

namespace App\Http\Middleware\Seekers;

use App\PsychoTestInfo;
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
            $psychoTest = PsychoTestInfo::where('room_code', $request->room_code)->first();
            $checkSeekerPsychoTest = PsychoTestResult::where('psychoTest_id', $psychoTest->id)
                ->where('seeker_id', $seeker->id)->count();
            if (!$checkSeekerPsychoTest) {
                return $next($request);
            }
        } elseif (Auth::guard('admin')->check()) {
            return $next($request);
        }
        return response(view('errors.403'), 403);
    }
}
