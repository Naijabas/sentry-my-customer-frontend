<?php

namespace App\Http\Middleware;

use Closure;

class StoreAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if ($request->cookie('user_role') == 'store_admin') {

            return $next($request);
        }
        return redirect()->route('dashboard');
    }
}
