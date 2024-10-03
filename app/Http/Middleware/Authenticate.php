<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth; /** @phpstan-ignore-line  */

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string[]  $guards
     * @return RedirectResponse|Response|Closure
     */
    public function handle($request, $next, ...$guards)
    {
        if (! $this->auth->guest()) {
            return $next($request);
        }

        if ($request->ajax()) {
            return response('Unauthorized.', 401);
        }

        return Redirect::route('login::show');
    }
}
