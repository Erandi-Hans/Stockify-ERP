<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the user is authenticated in the system
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Get authenticated user
        $user = Auth::user();

        // Check user role name safely
        $userRole = $user && $user->role ? $user->role->name : '';

        // Check if the user's assigned role exists within the allowed roles array
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Abort and show a 403 error if the user lacks sufficient permissions
        abort(403, 'Unauthorized access to this module.');
    }
}
