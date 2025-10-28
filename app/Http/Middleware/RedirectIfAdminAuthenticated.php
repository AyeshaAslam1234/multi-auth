<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdminAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // If admin is already logged in, redirect to dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin_dashboard');
        }

        return $next($request);
    }
}
