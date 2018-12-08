<?php

namespace App\Http\Middleware\Seekers;

use App\Seekers;
use Closure;
use Illuminate\Support\Facades\Auth;

class ProfileSeekerMiddleware
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
        $findSeeker = $request->id;
        if (Auth::check()) {
            if (Auth::user()->isSeeker()) {
                $seeker = Seekers::where('user_id', Auth::user()->id)->first();
                if ($seeker->id == $findSeeker) {
                    return $next($request);
                }

            } elseif (Auth::user()->isAgency()) {
                return $next($request);
            }

        } elseif (Auth::guard('admin')->check()) {
            return $next($request);

        } else {
            return redirect()->guest(route('home-seeker'))
                ->with('expire', 'The page you requested requires authentication, please login to your account.');
        }
        return response(view('errors.403'), 403);
    }
}
