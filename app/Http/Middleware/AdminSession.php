<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AdminSession
{
    public function handle(Request $request, Closure $next)
    {
        // Separate cookie for admin session
        Config::set('session.cookie', 'admin_session');
        return $next($request);
    }
}
