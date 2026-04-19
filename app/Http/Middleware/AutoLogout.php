<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AutoLogout
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in
        if (Session::has('login_id')) {
            $lastActivity = Session::get('last_activity_time');

            if ($lastActivity) {
                $inactiveMinutes = Carbon::now()->diffInMinutes(Carbon::parse($lastActivity));

                // If inactive for 60 minutes, log out
                if ($inactiveMinutes >= 60) {
                    Session::forget(['login_id', 'role', 'last_activity_time']);
                    return redirect()->route('login')->with('error', 'You have been logged out due to 1 hour of inactivity.');
                }
            }

            // Update last activity timestamp
            Session::put('last_activity_time', Carbon::now());
        }

        return $next($request);
    }
}
