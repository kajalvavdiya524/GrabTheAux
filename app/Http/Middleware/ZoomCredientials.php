<?php

namespace App\Http\Middleware;

use Closure;
use App\Meeting;
class ZoomCredientials
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
        $meeting = Meeting::where('user_id', \Auth::id())->first();
        if($meeting){
            return redirect(url('/meetings/create-zoom?name='.\Auth::user()->first_name.'&meeting_id='.$meeting->meeting_id.'&passcode='.$meeting->passcode.'&created_by_id='.\Auth::id()));
        }
        return $next($request);
    }
}
