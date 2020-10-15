<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;


class AuthBasic
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
       /*   if(Auth::onceBasic()){
            return response()->json(['mensaje' => 'Auth Failed'] , 404);
        }else{
             return $next($request);
        }  */
        return Auth::onceBasic() ?: $next($request);
       
    }
}
