<?php

namespace Proto\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use App;

class EnforceTFA
{
    /**
     * This middleware forces power users to use TFA before they can do anything else.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (App::environment('production') && Auth::check() && Auth::user()->hasRole(config('proto.tfaroles')) && (!Auth::user()->hasTFAEnabled())) {
            if (!$request->is('user/dashboard') && !$request->is('auth/logout') && !$request->is('user/quit_impersonating') && !$request->is('user/*/2fa/*') && !$request->is('user/2fa/*') && !$request->is('api/*')) {
                $request->session()->flash('flash_message', 'Your account permissions require you to enable Two Factor Authentication on your account before being able to use your account.');
                return Redirect::route('user::dashboard', array('#2fa'));
            }
        }

        return $next($request);
    }
}
