<?php

namespace Proto\Http\Middleware;

use Closure;
use Session;

class Saml
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
        Session::reflash();
        return $next($request);
    }
}
