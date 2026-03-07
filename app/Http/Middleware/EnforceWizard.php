<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnforceWizard
{
    /**
     * Handle an incoming request.
     *
     *
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (! $request->is('api/*') && Auth::check() && Auth::user()->wizard) {
            if (! $request->is('becomeamember')) {
                return to_route('becomeamember');
            }
            Auth::user()->update([
                'wizard' => false,
            ]);
        }

        return $next($request);
    }
}
