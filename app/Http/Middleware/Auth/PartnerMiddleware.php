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
        $partner = PartnerCredential::where('api_key', $request->key)->where('api_secret', $request->secret)
            ->where('status', true)->first();
        
        if ($partner != null) {
            if (today() > $partner->api_expiry) {
                return response()->json([
                    'status' => "403 ERROR",
                    'success' => false,
                    'message' => 'Forbidden Access! Your API has been expired, please update it.'
                ], 403);
            }
            $request->request->add([
                'partner' => $partner,
            ]);
            return $next($request);
        }

        return response()->json([
            'status' => "403 ERROR",
            'success' => false,
            'message' => 'Forbidden Access! Your client does not have permission to get URL /adsense from this server.'
        ], 403);
    }
}
