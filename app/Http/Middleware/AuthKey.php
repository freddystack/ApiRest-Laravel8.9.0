<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthKey
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
       /*  $token = $request->header('APP_KEY');
        if($token != 'MYSECRETTOKEN'){
            return  response()->json(['mensaje'=>'App key not found'], 401);
        }
        return $next($request); */

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
              if( $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                   return response()->json([
                      'success' => false,
                      'data' => 'Token Expirado'
                   ], 401);
              }else{
                  if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json([
                        'success' => false,
                        'data' => 'Token Invalido'
                     ], 401);
                  }else{
                        return response()->json([
                            'success' => false,
                            'error' => 'No tienes Authorizacion para entrar aqui',
                            'data' => 'Token Es Requerido'
                        ], 401);
                  }
              }
        }

        return $next($request->merge(['user' => $user]));
    }
}
