<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CustomAuthAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) {
            return redirect('admin/login'); // Redirect to the login page
        }

        // Check if the user has the required role
        $user = Auth::guard('admin')->user();

        if ($user->role != 2) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error','You have no access of this page');
        }
        return $next($request);
    }
}
