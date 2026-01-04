<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;

class VerifyMemberJWT
{
    public function handle($request, Closure $next)
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

        // Optional: inject user info
        $request->merge([
            'auth_user' => $response->json('user')
        ]);

        return $next($request);
    }
}

