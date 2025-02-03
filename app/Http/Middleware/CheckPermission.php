<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {   
        /** @var Guard $auth */
        $auth = auth();

        // Check if the user is authenticated
        if (!$auth->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Check if the user has the required permission
        if (!$auth->user()->hasPermission($permission)) {
            return response()->json(['error' => 'Forbidden - Insufficient permissions'], 403);
        }

        return $next($request);
    }
}
