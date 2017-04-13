<?php

namespace Proto\Http\Middleware;

use Closure;
use Auth;

class Utwente
{
    /**
     * This middleware only allows access if the visiting user is authenticated and is a member.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->utwente_username != null) {
            return $next($request);
        }
        abort(403, "You need to have an active University of Twente account to continue. If you have one, please link it on your dashboard.");
    }
}
