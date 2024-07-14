<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Member
{
    /**
     * This middleware only allows access if the visiting user is authenticated and is a member.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::user()?->is_member) {
            return $next($request);
        }

        return response('You need to be a member of S.A. Proto to see this page.', 403);
    }
}
