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
        $partner = PartnerCredential::where('api_key', $request->key)->when($request->has('api_secret') ? $request->api_secret : null, function ($query) use ($request) {
            $query->where('api_secret', $request->api_secret);
        })->first();

        if ($partner != null) {
            $request->request->add([
                'partner' => $partner
            ]);
            return $next($request);
        }

        return response()->json([
            'status' => 403,
            'success' => false,
            'message' => 'Forbidden Access!'
        ], 403);
    }
}
