<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    
{
   //\URL::forceScheme('https');
   //notificationCustomer();

        // $this->app['request']->server->set('HTTPS', true);

if (env('APP_ENV') === 'production') {

    $this->app['request']->server->set('HTTPS', true);

}

//notificationCustomer(); 
     
 Schema::defaultStringLength(191);
        Validator::extend('recaptcha', 'App\\Validators\\ReCaptcha@validate');
    }
}
