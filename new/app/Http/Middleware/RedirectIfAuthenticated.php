<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard'); // Redirect admin to dashboard
            } else {
                return redirect()->route('dashboard'); // Redirect normal user to dashboard
            }
        }

        return $next($request);
    }
}