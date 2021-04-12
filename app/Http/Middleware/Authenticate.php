<?php

namespace Proto\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * The Guard implementation.
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     * @param  Guard $auth
     * @return void
     */
    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, $next)
    {

        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('login::show');
            }
        }

        return $next($request);
    }
}
