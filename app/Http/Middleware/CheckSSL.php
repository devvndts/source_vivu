<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSSL
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
        $port = $request->getPort();
        $host = $request->getHost();
        $start = substr($host, 0, 3);

        if ($port === 80) {
            //return redirect()->secure('/');
            //return redirect()->secure($request->getRequestUri());
        }

        /*if ($start != 'www') {
            $request->headers->set('host', 'www.' . $request->getHost());
            return redirect()->to($request->getScheme() . '://' . $request->getHost() . $request->getRequestUri());
        }*/

        return $next($request);
    }
}
