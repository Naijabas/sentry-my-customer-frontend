<?php

namespace App\Http\Middleware;

use Closure;

class StoreAssistantAuth
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


        if ($request->cookie('user_role') == 'store_assistant') {

            return $next($request);
        }
        // return redirect()->route('dashboard');
    }
}
