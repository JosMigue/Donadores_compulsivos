<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsCurrentAdmin
{

    public function handle($request, Closure $next)
    {
        if(Auth::user()->is_super_admin){
            if($request->route('user')->is_admin){
                return $next($request);
            }else{
                return redirect('/home');
            }
        }else{
            if(Auth::user()->is_admin && Auth::user()->id == $request->route('user')->id && $request->route('user')->is_admin){
                return $next($request);
            }else{
                return redirect('/home');
            }
        }
    }
}
