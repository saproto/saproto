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
        abort_unless(Auth::check(), 403, 'You need to be logged in to access this page.');

        abort_unless(Auth::user()?->is_member, 403, 'You need to be a member to access this page.');

        return $next($request);
    }
}
