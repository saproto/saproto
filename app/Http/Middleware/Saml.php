<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Saml
{
    public function handle(Request $request, Closure $next): mixed
    {
        Session::reflash();

        return $next($request);
    }
}
