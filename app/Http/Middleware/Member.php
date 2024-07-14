<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class Member
{
    /**
     * This middleware only allows access if the visiting user is authenticated and is a member.
     *
     * @param Request $request
     * @param Closure $next
     * @return Mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::user()?->is_member) {
            return $next($request);
        }
        return response('You need to be a member of S.A. Proto to see this page.', 403);
    }
}
