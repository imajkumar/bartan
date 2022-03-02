<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Session;
use Auth;

class SalesLogoutAfterSomeDays
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
        $logoutData = Cache::get('salesLogoutAfterSomeDays');
        if (empty($logoutData)) {
            
            Auth::logout();
            session()->forget('customer');
            session()->forget('sales');
            Session::flush();

            //return redirect('/');
            
            return redirect()->route('salesLoginLayout');
        }

        return $next($request);
    }
}
