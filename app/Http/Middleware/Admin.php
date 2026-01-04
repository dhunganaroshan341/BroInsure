<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {

            if (!$request->ajax()) {
                $checkmenuaccess = checkmenupermission();
                if ($checkmenuaccess < 1) {
                    if (!is_null(getUserDetail()->redirect_url)) {
                        # code...
                        return redirect(getUserDetail()->redirect_url);
                    } else {
                        # code...
                        return redirect('admin/404');
                    }
                    

                }
            }
            if (!$request->ajax() && Auth::guard('admin')->user()->default_password != null && request()->path() != 'admin/changepassword') {
                return redirect('admin/changepassword');
            }
            return $next($request);
        } else {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthenticated User'], 401);
            } else {
                return redirect('login');
            }
        }

        return redirect('login');
    }
}
