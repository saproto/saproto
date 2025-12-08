<?php

namespace App\Http\Middleware;

use App\Models\HashMapItem;
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
        if (Auth::check() && HashMapItem::query()->key('wizard')->subkey((string) Auth::user()->id)->first() && ! $request->is('api/*')) {
            if (! $request->is('becomeamember')) {
                return to_route('becomeamember');
            }

            HashMapItem::query()->key('wizard')->subkey((string) Auth::user()->id)->first()->delete();
        }

        return $next($request);
    }
}
