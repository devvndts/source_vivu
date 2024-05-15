<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

use Helper;

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
        //dd(Auth::guard('admin'));
        if (! $request->expectsJson()) {
            //dd($request->cookie('laravel_session'));  
            if(Helper::GetPrefixMain($request)==app('settingOptions')['linkadmin'] || Helper::GetPrefixAdmin($request)==app('settingOptions')['linkadmin']){
                return route('admin.login');
            }
            return route('login');
        }
    }
}
