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

        if (!Auth::check())
            return redirect('login');

        $user = Auth::user();

        if($user->isAdmin())
            return $next($request);

        foreach($roles as $role){
            if($user->hasRole($role)){
                return $next($request);
            }
        }

        return $next($request);

    }
}
