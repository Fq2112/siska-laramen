<?php

namespace App\Http\Middleware\Agencies;

use App\Agencies;
use App\ConfirmAgency;
use Closure;
use Illuminate\Support\Facades\Auth;

class InvoiceAgencyMiddleware
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
            if (Auth::check() && Auth::user()->isAgency()) {
                $agency = Agencies::where('user_id', Auth::user()->id)->first();
                $check = ConfirmAgency::where('id', decrypt($request->route('id')))
                    ->where('agency_id', $agency->id)->firstOrFail();
                if ($check != null) {
                    return $next($request);
                }
            }
        }
        return response()->view('errors.403');
    }
}
