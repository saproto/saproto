<?php

namespace Proto\Http\Middleware;

use Closure;

class EnforceHTTPS
{
    /**
     * This middleware forces the entire application to use SSL. We like that, because it's secure.
     *
     * Shamelessly copied from: http://stackoverflow.com/questions/28402726/laravel-5-redirect-to-https
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && env('SSL', true)) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
