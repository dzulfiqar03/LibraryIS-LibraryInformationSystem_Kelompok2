<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle($request, Closure $next, $role)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }

        $response = Http::withToken($token)
            ->get('http://127.0.0.1:8001/api/validate-token');

        if ($response->failed()) {
            return response()->json(['message' => 'Token invalid'], 401);
        }

        $user = $response->json('user');

        if ($user['user_detail']['roles']['role'] !== $role) {
            return response()->json(['message' => 'Forbidden - ' . $role . ' only'], 403);
        }

        // Optional: inject user info
        $request->merge([
            'auth_user' => $response->json('user')
        ]);

        return $next($request);
    }
}
