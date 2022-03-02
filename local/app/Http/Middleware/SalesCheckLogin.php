<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
//use session;
class SalesCheckLogin
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
        $sales = session()->get('sales');
        
        if (!$sales) {
           
            return redirect()->route('salesLoginLayout');
            //dd($customer);
        }
        //if (Auth::check() && Auth::user()->id) {
           
            
        //}
        //return $next($request);
        //return route('showCustomerLoginForm');
        //($request->all());
        
        // if (! $request->()) {
        //     return route('home');
        // }
        return $next($request);
    }
}
