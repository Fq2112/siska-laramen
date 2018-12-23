<?php

namespace App\Http\Middleware\Auth;

use App\PartnerCredential;
use Closure;

class PartnerMiddleware
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
        $partner = PartnerCredential::where('api_key', $request->key)->where('api_secret', $request->secret)->first();

        if ($partner != null) {
            if (today() > $partner->api_expiry) {
                return response()->json([
                    'status' => "403 Error",
                    'success' => false,
                    'message' => 'API expired! Please request a new one.'
                ], 403);
            }
            return $next($request);
        }

        return response()->json([
            'status' => "403 Error",
            'success' => false,
            'message' => 'Forbidden Access!'
        ], 403);
    }
}
