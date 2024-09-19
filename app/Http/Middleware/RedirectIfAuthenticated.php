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
            $adminDashboard = route('admin.dashboard');
            $instructorDashboard = route('instructor.dashboard');

            if ($user->role == 'admin' && $request->url() !== $adminDashboard) {
                return redirect($adminDashboard);
            } elseif ($user->role == 'instructor' && $request->url() !== $instructorDashboard) {
                return redirect($instructorDashboard);
            }
        }

        return $next($request);
    }
}