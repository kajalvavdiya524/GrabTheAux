<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckMembership
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
        $user = Auth::user();
        if ($user->hasRole('User') && $user->membership == null) {
             return redirect('/membership/payment-detail')->with('msg' , 'Please pay for Membership before proceeding further!');
         }

       return $next($request);
    }
}
