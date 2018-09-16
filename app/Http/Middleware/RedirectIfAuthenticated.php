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
                if(Auth::user()->isRoot()){
                    return redirect()->route('home-seeker');
                }
                elseif(Auth::user()->isAdmin()){
                    return redirect()->route('home-seeker');
                }
                elseif(Auth::user()->isSeeker()){
                    return redirect()->route('home-seeker');
                }
                elseif(Auth::user()->isAgency()){
                    return redirect()->route('home-agency');
                }
            }
        }

        return $next($request);
    }
}
