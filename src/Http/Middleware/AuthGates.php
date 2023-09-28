<?php


namespace Lcloss\SimplePermission\Http\Middleware;

use Auth;
use Closure;
use Gate;
use Illuminate\Http\Request;

class AuthGates
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle( Request $request, Closure $next )
    {
        if (Auth::check()) {
            $user = Auth::user();

            $roles = $user->roles()->with('permissions')->get();
            $permissionsArray = [];

            foreach ($roles as $role) {
                foreach ($role->permissions as $permission) {
                    $permissionsArray[$permission->name][] = $role->id;
                }
            }

            foreach ($permissionsArray as $name => $role_id) {
                Gate::define($name, function ( $user ) use ( $name, $role_id ) {
                    return count(array_intersect($user->roles->pluck('id')->toArray(), $role_id)) > 0;
                });
            }
        }

        return $next($request);
    }
}
