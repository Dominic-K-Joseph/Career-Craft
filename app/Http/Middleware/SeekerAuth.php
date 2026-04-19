<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SeekerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('login_id') || session('role') !== 'seeker') {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please log in as a job seeker to continue.'
                ], 401);
            }

            return redirect()->route('login');
        }

        return $next($request);
    }
}
