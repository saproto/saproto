<?php

namespace Proto\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use App;

class EnforceTFA
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
        if (App::environment('production', 'staging') && Auth::check() && Auth::user()->hasRole(config('proto.tfaroles')) && (!Auth::user()->tfa_totp_key && !Auth::user()->tfa_yubikey_identity)) {
            if (!$request->is('user/dashboard') && !$request->is('user/*/2fa/*') && !$request->is('auth/logout')) {
                $request->session()->flash('flash_message', 'Since you are able to access a lot of sensitive information, you are required to enable Two Factor Authentication on your account. Please do so now! :)');
                return Redirect::route('user::dashboard');
            }
        }

        return $next($request);
    }
}
