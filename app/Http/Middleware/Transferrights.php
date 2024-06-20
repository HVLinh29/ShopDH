<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class Transferrights
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session()->has('transferrights')){
            Auth::onceUsingId(session('transferrights'));
        }
        return $next($request);
    }
}
