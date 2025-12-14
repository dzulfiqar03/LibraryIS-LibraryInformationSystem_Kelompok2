<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
{
    $user = Auth::user();

    // Ambil nama role dari relasi
    $userRole = optional(optional($user->user_detail)->roles)->role;

    if ($userRole !== $role) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
}

}
