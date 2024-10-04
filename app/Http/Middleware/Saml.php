<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;

class Saml
{
    public function handle($request, $next)
    {
        Session::reflash();

        return $next($request);
    }
}
