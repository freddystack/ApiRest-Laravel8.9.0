<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReceptionMiddleware
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
        $user = $request->get('user');
        if($user['roll'] != 'reception' ){
           return response()->json([
              'success' => false,
               'data' => 'No estas autorizado para entrar'
           ], 401);

        }

        return $next($request);
    }
}
