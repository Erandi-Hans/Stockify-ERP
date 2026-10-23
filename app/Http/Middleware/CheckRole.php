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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the user is authenticated in the system
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Get authenticated user
        $user = Auth::user();

        // Get user role ID and role name safely to prevent null errors
        $userRoleId = $user->role_id ?? null;
        $userRoleName = ($user->role && isset($user->role->name)) ? $user->role->name : '';

        // Check if the user's role ID or role name matches any of the allowed roles
        foreach ($roles as $role) {
            // Compare against both role_id (e.g., 1, 2, 3) and role name (e.g., Admin, Sales, Inventory)
            if (
                $userRoleId == $role ||
                strcasecmp($userRoleName, $role) === 0
            ) {
                return $next($request);
            }
        }

        // Abort and show a 403 error if the user lacks sufficient permissions
        abort(403, 'Unauthorized access to this module.');
    }
}
