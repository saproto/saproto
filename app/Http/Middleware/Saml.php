<?php

namespace Proto\Http\Middleware;

use Closure;
use Session;

class Saml
{
    public function handle($request, $next)
    {
        Session::reflash();
        return $next($request);
    }
}
