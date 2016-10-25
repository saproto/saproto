<?php

namespace Proto\Http\Middleware;

use Auth;
use Closure;
use Redirect;

class EnforceWizard
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
        if (Auth::check() && Auth::user()->wizard) {
            if (!$request->is('becomeamember')) {
                return Redirect::route('becomeamember');
            }
            $user = Auth::user();
            $user->wizard = false;
            $user->save();
        }
        return $next($request);
    }
}
