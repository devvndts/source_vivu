<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /*
        |--------------------------------------------------------------------------
        | Danh sách giao diện trang lỗi
        |--------------------------------------------------------------------------
        */
        $page_403 = redirect()->route('admin.error.show', '403');
        $page_login = redirect()->route('admin.login');

        /*
        |--------------------------------------------------------------------------
        | kiểm tra role admin
        |--------------------------------------------------------------------------
        */
        //if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->role==3){
        if(Auth::guard('admin')->check()){
            $isCheckLogin = session('isCheckLogin');
            if(!$isCheckLogin){
                return $page_login;
            }
            return $next($request);
        }
        return $page_403;
    }
}
