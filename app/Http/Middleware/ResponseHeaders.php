<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use Illuminate\Http\Request;

class ResponseHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $domain = $request->header("Origin");
        if(preg_match("/(garan24|payneteasy|magnitolkin|laalmare|\.bs2|gauzymall)/i",$domain)){
            return $next($request)
               ->header('Access-Control-Allow-Origin', $domain)
               ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        }
        return $next($request);
    }
}
