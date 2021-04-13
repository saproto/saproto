<?php

namespace Proto\Http\Middleware;

use Closure;
use Session;

class Saml
{
    public function handle($request, Closure $next)
    {
        Session::reflash();

        return $next($request);
    }
}
