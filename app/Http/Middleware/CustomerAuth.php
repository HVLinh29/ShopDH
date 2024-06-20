<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class CustomerAuth
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
        if (!Session::has('customer_id')) {
            return redirect('/login_checkout')->with('error', 'You need to log in first.');
        }

        return $next($request);
    }
}
