<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Support\Facades\DB;

class HasPrivilege
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        $hasPrivilege = DB::table('user_privilege')->where('empid',Auth::user()->EmpId)->value(request()->segment(1));
//        dd($hasPrivilege);
        if(!$hasPrivilege){
            abort(401);
        }

        return $next($request);
    }
}
