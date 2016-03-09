<?php

/**
 * Kindly copied from
 * http://stackoverflow.com/questions/33791494/laravel-restricting-access-for-development-site
 */

namespace Proto\Http\Middleware;

use Closure;

class DevelopmentAccess
{
    /**
     * Client IPs allowed to access the app.
     * Defaults are loopback IPv4 and IPv6 for use in local development.
     *
     * @var array
     */
    protected $ipWhitelist = array();

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->ipWhitelist = explode(',', getenv('DEV_ALLOWED'));

        if (app()->environment() != 'production' && app()->environment() != 'staging' && $this->clientNotAllowed()) {
            config(['app.debug' => false]);
            return abort(403, 'You cannot access the development environment from this IP. Try <a href="https://staging.saproto.nl/">staging</a> if you are interested.');
        }
        return $next($request);
    }

    /**
     * Checks if current request client is allowed to access the app.
     *
     * @return boolean
     */
    protected function clientNotAllowed()
    {
        $isAllowedIP = in_array(request()->ip(), $this->ipWhitelist);

        if(!auth()->guest()) {
            return false;
        }elseif(auth()->guest() && $isAllowedIP) {
            return false;
        }else{
            return true;
        }
    }
}
