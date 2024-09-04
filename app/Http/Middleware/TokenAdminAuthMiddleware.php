<?php

namespace App\Http\Middleware;

use App\Helpers\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenAdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');
        $decoded = JWTToken::decodeToken($token);
        if ($decoded == "Unauthorized") {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if ($decoded->is_admin == 0) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->headers->set('email', $decoded->email);
        $request->headers->set('id', $decoded->id);
        $request->headers->set('is_admin', $decoded->is_admin);
        return $next($request);
    }
}