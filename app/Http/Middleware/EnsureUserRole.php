<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        // If accessing the new-user-homepage, skip the role check to avoid the loop.
        if ($request->route()->getName() === 'new-user-homepage') {
            if($user->hasRole('user'))
                return $next($request);
            else
                return redirect()->route('dashboard1');
        }

        // If the user is an admin, let them proceed.
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        // Check if the user has any of the required roles.
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // If the user does not have the required role, redirect them.
        return redirect('new-user-homepage');
    }
}
