<?php

namespace Proto\Http\Middleware;

use Closure;
use Auth;

class Member
{
    /**
     * This middleware only allows access if the visiting user is authenticated and is a member.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_member) {
            return $next($request);
        }
        abort(403, "You need to be a member of S.A. Proto to see this page.");
    }
}
