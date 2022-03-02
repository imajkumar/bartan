<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
//use session;
use Illuminate\Support\Facades\Cache;
use Session;

class IsAdminLogin

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
        // pr(Auth::user()->user_type == 0);
        $customer = Auth::user();
        //$logoutData = Cache::get('logoutSomeDays');
        // echo Auth::user()->user_type;exit('ff');
        if (Auth::user()->user_type != 1) {

           
            return redirect()->route('home');
            //dd($customer);
        }
        
        // if (! $request->()) {
        //     return route('home');
        // }
        return $next($request);
    }
}
