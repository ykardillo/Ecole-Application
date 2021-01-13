<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TeacherMiddleware
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
        if(Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'teacher' ){
            return $next($request);
        }else{
            return redirect("/homes")->with('status','Vous n\'êtes pas autorisé sur cette page');
        }
    }
}
