<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // if (Auth::check() && in_array(Auth::user()->role_id, explode('|', $role)) ) {
        //     return $next($request);
        // }
        if (Auth::check()) {
            $role_id = auth()->user()->role_id;
            $roles_permissions = DB::table('roles_permissions')
                ->join('permissions as p', 'p.id', '=', 'roles_permissions.permission_id')
                ->where('role_id', $role_id)
                ->pluck('permission_name')->toArray();
            $check = in_array($permission, $roles_permissions);
            // dd($check);
            if ($check) return $next($request);
        }
        return abort(403, 'unauthorized');
    }
}
