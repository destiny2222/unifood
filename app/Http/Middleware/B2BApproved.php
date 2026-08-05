<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class B2BApproved
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->kyc_id || !$user->kyc || $user->kyc->status !== 'approved') {
            return response()->json([
                'error' => 'Your trade account is pending approval or has not been approved. Access is denied.'
            ], 403);
        }

        return $next($request);
    }
}
