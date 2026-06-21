<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureCompanyVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'company') {
                if (!$user->isVerified()) {
                    if (!$request->routeIs('company.pending')) {
                        return redirect()->route('company.pending');
                    }
                } else {
                    if ($request->routeIs('company.pending')) {
                        return redirect()->route('company.dashboard');
                    }
                }
            }
        }

        return $next($request);
    }
}
