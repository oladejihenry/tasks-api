<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LastLogin
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
        if (auth()->guest()) {
            return $next($request);
        }
        if (auth()->user()->last_login->diffInHours(now()) !==0)
        { 
            DB::table("users")
              ->where("id", auth()->user()->id)
              ->update(["last_login" => now()]);
        }
        return $next($request);
    }
}
