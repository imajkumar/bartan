<?php

namespace App\Http\Middleware;
//use session;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Cache;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        Cache::put('AdminLogoutAfterSomeDays', 'this_admin', $seconds = 15*60*60*24);
        
        // $customer = session()->get('customer');
        // if (! $customer) {
        //     return redirect('home');
        // }
        if (! $request->expectsJson()) {
            return route('login');
        }
        
    }
}
