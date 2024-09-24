<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $currentRouteName = $request->route()->getName(); // Get the current route name

            $adminDashboard = 'admin.dashboard';
            $instructorDashboard = 'instructor.dashboard';

            if ($user->role == 'admin' && $currentRouteName !== $adminDashboard) {
                return redirect()->route($adminDashboard);
            } elseif ($user->role == 'instructor' && $currentRouteName !== $instructorDashboard) {
                return redirect()->route($instructorDashboard);
            }
        }

        return $next($request);
    }
}