<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        /** @var Guard $auth */
        $auth = auth();

        // Now Intelephense will recognize the methods
        if (!$auth->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        $user = $auth->user();
        if (!$user->roles()->where('role_name', $role)->exists()) {
            return response()->json(['error' => 'Forbidden - Insufficient role access '. $role], 403);
        }


        return $next($request);
    }
}
