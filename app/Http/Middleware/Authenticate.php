<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class Authenticate extends \Illuminate\Auth\Middleware\Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Factory
     */
    protected $auth;

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  string[]  $guards
     */
    public function handle($request, Closure $next, ...$guards): Response|Closure|RedirectResponse
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
