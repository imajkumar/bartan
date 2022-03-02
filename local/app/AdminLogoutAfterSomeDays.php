<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Session;
use Auth;

class AdminLogoutAfterSomeDays
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
        // cache value set in Authenticate.php middlewae
        $logoutData = Cache::get('AdminLogoutAfterSomeDays');
        // echo $logoutData;exit;
        if (empty($logoutData)) {
            
            Auth::logout();
            session()->forget('customer');
            session()->forget('sales');
            Session::flush();

            return redirect('/');
            
            //return redirect()->route('showCustomerLoginForm');
        }

        return $next($request);
    }
}
