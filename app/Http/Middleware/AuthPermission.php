<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        /*
        |--------------------------------------------------------------------------
        | Danh sách giao diện trang lỗi
        |--------------------------------------------------------------------------
        */
        $page_error = redirect()->route('admin.error.show','403');

        if(!Auth::guard('admin')->user()->can($permission) && Auth::guard('admin')->user()->role!=3){
            return $page_error;
        }
        return $next($request);
    }
}
