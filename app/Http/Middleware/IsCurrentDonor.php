<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class IsCurrentDonor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       if(Auth::user()->is_admin){
           return $next($request);
       }else{
           if(Auth::user()->load('donor')->donor->id == $request->route('donor')->id){
               return $next($request);
           }else{
               return abort(401);
           }
       }
    }
}
