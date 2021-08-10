<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckEmpleado
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
        $userRoles= Auth::user()->roles->pluck('name');
        if(!$userRoles->contains('empleado')){
           return redirect('/permission-denied'); 
        }
        return $next($request);
    }
}