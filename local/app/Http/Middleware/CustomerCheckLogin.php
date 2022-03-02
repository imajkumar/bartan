<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
//use session;
use Illuminate\Support\Facades\Cache;
use Session;

class CustomerCheckLogin

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
        $customer = session()->get('customer');
        //$logoutData = Cache::get('logoutSomeDays');
        
        if (!$customer) {
        //    echo "dddddddddd";exit;
            // Auth::logout();
            // session()->forget('customer');
            // session()->forget('sales');
            // Session::flush();
            return redirect()->route('showCustomerLoginForm');
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
