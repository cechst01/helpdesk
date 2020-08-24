<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\AllowedIpAddress;

class Admin
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
        if(!Auth::user()->admin){
           return redirect('dashboard')->with('error','Pro tuto akci nemáte dostatečné oprávnění.');
        }
        return $next($request);
    }
}
