<?php

/**
 * Kindly copied from
 * http://stackoverflow.com/questions/33791494/laravel-restricting-access-for-development-site
 */

namespace Proto\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DevelopmentAccess
{
    protected $except = [
        'webhook/*'
    ];

    /** @var array Client IPs allowed to access the app. Defaults are loopback IPv4 and IPv6 for use in local development. */
    protected $ipWhitelist = [];

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        if (config('app-proto.debug-whitelist') == null) {
            return $next($request);
        }

        $this->ipWhitelist = explode(',', config('app-proto.debug-whitelist'));

        if ($this->clientNotAllowed()) {
            config(['app.debug' => false]);
            return abort(403);
        }

        return $next($request);
    }

    /** @return bool Whether the current request client is allowed to access the app. */
    protected function clientNotAllowed()
    {
        $isAllowedIP = in_array(request()->ip(), $this->ipWhitelist);

        if (!auth()->guest()) return false;
        elseif (auth()->guest() && $isAllowedIP) return false;
        else return true;
    }
}
