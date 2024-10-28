<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as LaravelAuthenticate;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class Authenticate extends LaravelAuthenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    /** @phpstan-ignore-line */

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  string[]  $guards
     * @return RedirectResponse|Closure
     */
    public function handle($request, Closure $next, ...$guards): Response|RedirectResponse
    {
        if (auth()->guest()) {
            return Redirect::route('login::show');
        }

        if ($request->ajax()) {
            abort('Unauthorized.', 401);
        }

        return $next($request);
    }
}
